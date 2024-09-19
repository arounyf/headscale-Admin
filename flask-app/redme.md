#### 文档
cd ~/hs-admin/flask-app
python3 -m venv tutorial-env
source tutorial-env/bin/activate
pip install flask
pip install psutil
nohup python app.py eth0 > app.log 2>&1 &
# eth0修改为你的网卡名