#! /bin/bash
source tutorial-env/bin/activate
nohup python app.py > output.log 2>&1 &