# Import necessary libraries
from flask import Flask, Response
import cv2
import os

# Initialize Flask app
app = Flask(__name__)

# Initialize camera
cam1 = -1
x = 0
while cam1 == -1 and x < 42:
    txt = "v4l2-ctl -d " + str(x) + " --list-ctrls > cam_ctrls.txt"
    os.system(txt)
    ctrls = []
    with open("cam_ctrls.txt", "r") as file:
        line = file.readline()
        while line:
            ctrls.append(line)
            line = file.readline()
    if 'User Controls\n' in ctrls and ('Camera Controls\n' in ctrls):
        cam1 = x
    else:
        x += 1

print("Camera index:", cam1)  # Print the camera index

if cam1 == -1:
    print(" No USB camera found !!")

vid1 = cv2.VideoCapture(cam1)
vid1.set(cv2.CAP_PROP_FRAME_WIDTH, 640)
vid1.set(cv2.CAP_PROP_FRAME_HEIGHT, 480)

# Define a function to generate frames from the camera
def generate_frames():
    while True:
        # Read a frame from the camera
        ret, frame = vid1.read()
        if not ret:
            break
        else:
            # Encode the frame as JPEG
            ret, buffer = cv2.imencode('.jpg', frame)
            if not ret:
                break
            # Yield the frame in byte format
            yield (b'--frame\r\n'
                   b'Content-Type: image/jpeg\r\n\r\n' + buffer.tobytes() + b'\r\n')

# Define a route for serving the camera stream
@app.route('/video_feed')
def video_feed():
    return Response(generate_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')

if __name__ == '__main__':
    app.run(host='192.168.1.212', port=5000)
