
# 介绍
[![GitHub repo size](https://img.shields.io/github/repo-size/arounyf/headscale-Admin)](https://github.com/arounyf/headscale-Admin)
[![Docker Image Size](https://img.shields.io/docker/image-size/runyf/hs-admin)](https://hub.docker.com/r/runyf/hs-admin)
[![docker pulls](https://img.shields.io/docker/pulls/runyf/hs-admin.svg?color=brightgreen)](https://hub.docker.com/r/runyf/hs-admin)
[![platfrom](https://img.shields.io/badge/platform-amd64%20%7C%20arm64-brightgreen)](https://hub.docker.com/r/runyf/hs-admin/tags)

采用Think-php6+layui+flask开发，基于用户的headscale后台管理中心,欢迎点一个Star   
qq群 892467054
# 时间线
2024年6月我接触到了tailscale,后在个人博客上发布了derper与headscale的搭建教程   
2024年9月8日headscale-Admin首个版本正式开源发布
# 安装
### 传统安装
 1. 安装php-composer
 2. 使用composer安装think-captcha
 3. 安装psql驱动
### 使用docker部署（推荐）
1. 首先需要部署headscale，请查看 /headscale/docker-compose.yml
```shell
cd
git clone https://github.com/arounyf/headscale-Admin.git hs-admin
cd hs-admin/headscale
docker-compose up -d
cd ..
docker-compose up -d
```
2. 修改配置文件
```shell
vim headscale/config.yml
cd think-app
cp .example.env .env
vim .env
```
3. 初始化sqlite数据库
`curl 172.17.0.1:8011/install`



# 功能
- 用户管理
- 用户自行注册
- 用户到期管理
- 流量统计
- 基于用户ACL
- 节点管理
- 路由管理
- 日志管理
- 预认证密钥管理
- 角色管理
- api和menu权限管理
- 支持postsql与sqlite数据库
# 兼容性
仅通过headscale:v0.22.3测试

# 系统截图

![console](https://github.com/user-attachments/assets/6e25da2f-39f9-4217-b79e-344221c8f816)
![user](https://github.com/user-attachments/assets/1906c6ec-eb6f-44b1-af88-237ec16f1e99)
![reg](https://github.com/user-attachments/assets/59a43c57-682a-4cfd-83c0-8aa3d48a3d67)
![login](https://github.com/user-attachments/assets/e3d4029f-cc08-41e7-8dec-7cae4748a761)






