from flask import Flask, jsonify
import psutil
import subprocess
import json
import math

app = Flask(__name__)

# 重载配置文件
@app.route('/reload_acl', methods=['GET'])
def get_reload_acl():
    result = subprocess.run(["docker", "kill", "--signal", "HUP", "headscale"],capture_output=True,check=True)
    return jsonify({'result': result.stdout.decode('utf-8')})
    
# 获取系统相关信息
@app.route('/info', methods=['GET'])
def get_info():
    cpu_usage = psutil.cpu_percent()
    
    memory_info = psutil.virtual_memory()
    memory_usage_percent = memory_info.percent
    
    
    recv = {}
    sent = {}
    net_interface = "ens18"

    data = psutil.net_io_counters(pernic=True)
    interfaces = data.keys()
    for interface in interfaces:
        if interface == net_interface:  # 只处理 ens18 网卡
            sent.setdefault(interface, data.get(interface).bytes_sent)
            recv.setdefault(interface, data.get(interface).bytes_recv)
            
            
            sent_speed = math.ceil(sent.get(net_interface)/ 1024 )
            recv_speed = math.ceil(recv.get(net_interface)/ 1024 )
       
    
    info_dict = {
        'cpu_usage': cpu_usage,
        'memory_usage_percent': memory_usage_percent,
        'sent_speed': sent_speed,
        'recv_speed': recv_speed
    }
    
    return json.dumps(info_dict)


# 记录数据
@app.route('/data_record', methods=['GET'])


def get_data_record():


    json_data_now = json.loads(get_info())

    recv_speed = str(json_data_now["recv_speed"])
    sent_speed = str(json_data_now["sent_speed"])

    with open('data.json', 'r') as file:
        content = file.read()
        json_data_local = json.loads(content)

        

        keys = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l','m', 'n', 'o', 'p','q', 'r', 's', 't', 'u','v', 'w', 'x', 'y']
        for i in range(len(keys) - 1):
            json_data_local['sent'][keys[i]] = json_data_local['sent'][keys[i + 1]]
            json_data_local['recv'][keys[i]] = json_data_local['recv'][keys[i + 1]]

    
       
        json_data_local["sent"]["y"] = sent_speed
        json_data_local["recv"]["y"] = recv_speed

    with open('data.json', 'w') as file:
        json.dump(json_data_local, file, indent=4)



    return json_data_local
    





# 获取数据
@app.route('/data_usage', methods=['GET'])
def get_data_usage():
    with open('data.json', 'r') as file:
        content = file.read()
        json_data = json.loads(content)


        data_dict = json_data

        # 处理 recv 字典
        recv_values = list(data_dict['recv'].values())
        new_recv_values = [math.ceil(float(recv_values[i + 1]) - float(recv_values[i])) for i in range(len(recv_values) - 1)]
        new_recv_dict = {f"{chr(ord('a') + i)}": str(new_recv_values[i]) for i in range(len(new_recv_values))}

        # 处理 sent 字典
        sent_values = list(data_dict['sent'].values())
        new_sent_values = [math.ceil(float(sent_values[i + 1]) - float(sent_values[i])) for i in range(len(sent_values) - 1)]
        new_sent_dict = {f"{chr(ord('a') + i)}": str(new_sent_values[i]) for i in range(len(new_sent_values))}


        # 构建新的字典
        new_data_dict = {"recv": new_recv_dict, "sent": new_sent_dict}

        # 转换回 JSON 字符串并打印
        new_data = json.dumps(new_data_dict)

        return new_data
    
    
if __name__ == '__main__':
    app.run(host="0.0.0.0",port=5000,debug=True)