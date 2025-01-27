#!/bin/bash

# Log file location
LOG_FILE="/home/pi/Desktop/Object_Detection_Files/capture_image.log"

echo "Stopping camerafinal1.py..." | tee -a $LOG_FILE

# Find the PID of the camera script and kill it
PIDS=$(ps aux | grep '[c]amerafinal1.py' | awk '{print $2}')
if [ -n "$PIDS" ]; then
    for PID in $PIDS; do
        echo "Killing process $PID" | tee -a $LOG_FILE
        kill $PID
        sleep 2
        # Ensure it is killed
        if ps -p $PID > /dev/null; then
            echo "Force killing process $PID" | tee -a $LOG_FILE
            kill -9 $PID
        fi
    done
else
    echo "camerafinal1.py not running" | tee -a $LOG_FILE
fi

# Check for any Python process running from the Object_Detection_Files directory
PIDS=$(ps aux | grep '[p]ython3 .*Object_Detection_Files' | awk '{print $2}')
if [ -n "$PIDS" ]; then
    for PID in $PIDS; do
        echo "Killing process $PID running from Object_Detection_Files" | tee -a $LOG_FILE
        kill $PID
        sleep 2
        # Ensure it is killed
        if ps -p $PID > /dev/null; then
            echo "Force killing process $PID" | tee -a $LOG_FILE
            kill -9 $PID
        fi
    done
else
    echo "No Python process running from Object_Detection_Files" | tee -a $LOG_FILE
fi

# Change to the directory
cd /var/www/html/teste

echo "Taking picture..." | tee -a $LOG_FILE

# Run the node script to execute the fswebcam command
sudo node photo.js "fswebcam -r 1920x1080 --jpeg 85 -D 1 /var/www/html/teste/foto/captured_image.jpg"
sudo yolov5 detect

echo "Picture taken and saved to /var/www/html/teste/captured_image.jpg" | tee -a $LOG_FILE

