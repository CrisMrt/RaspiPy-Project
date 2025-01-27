# RaspiPy Project

## Introduction
The RaspiPy project is an advanced robotics system designed as part of a Prova de Aptidão Profissional (PAP). It integrates multiple technologies, including robotics, computer vision, and web development, to create an interactive robot. The robot, controlled via a web interface, includes functionalities such as real-time video streaming, object recognition, voice interaction, and performance monitoring. This project highlights the potential of Raspberry Pi in educational and real-world applications.

## Features
- **Real-Time Robot Control**: Navigate the robot using a web interface or keyboard controls.
- **Live Video Feed**: View the robot's camera feed in real-time.
- **Object Recognition**: Capture photos and identify objects using YOLOv5.
- **Voice Interaction**: Interact with the robot through voice commands using WhisperV3 and ChatGPT-4.
- **Performance Monitoring**: Track Raspberry Pi's CPU, memory, and temperature metrics.
- **User-Friendly Web Interface**: Access all functionalities through an intuitive web platform.

## Technologies Used
### Hardware
- **Raspberry Pi Model 4-B**
- **Logitech C270 Webcam**
- **ZYTD520 Motors and Motor Controller**
- **Mini USB Microphone**
- **PowerBank for Power Supply**

### Software
- **Languages**: Python, PHP, HTML, CSS, JavaScript, SQL
- **Libraries**: OpenCV, YOLO, Flask, RPI.GPIO
- **Frameworks**: Node.js, Apache
- **Database**: MariaDB

## Installation
### Prerequisites
1. **Hardware Setup**:
   - Ensure all components (Raspberry Pi, motors, camera, etc.) are properly connected.
2. **Software Setup**:
   - Install required libraries and dependencies (OpenCV, YOLO, Flask, etc.).
   - Set up the Apache server and MariaDB database.

### Steps
1. Clone or download the project repository.
2. Deploy the website files in the Apache server directory (`/var/www/html/`).
3. Configure the `conexaoBd.php` file for database connectivity.
4. Import the database schema from the provided `.sql` file into MariaDB.
5. Start the Apache server and Flask application.
6. Access the web interface via `http://<raspberry-pi-ip-address>/index.php`.

## How It Works
### Robot Control
- Use the `W`, `A`, `S`, `D` keys or on-screen buttons to navigate the robot.
- Press the "Stop" button after each movement to halt the robot.

### Video Streaming
- View a live video feed from the robot's camera on the web interface.

### Object Recognition
- Capture photos via the "Take Photo" button.
- Identified objects are highlighted in the photo, which can be downloaded.

### Voice Interaction
- Click "Ask a Question" to record a 5-second audio.
- The audio is transcribed and processed to provide a text-based response.

### Performance Monitoring
- Monitor real-time data such as CPU usage, memory, and temperature via the web interface.

## Challenges Encountered
- **SD Card Corruption**: Resolved through frequent backups and using higher-quality cards.
- **Server Configuration**: Ensured stability and security for resource-limited hardware.
- **Component Failures**: Adapted with alternative solutions, like replacing the cooler with one from an old hard drive.

## Credits
- **Project Creator**: Cristiano David Paulitos Martinho
- **Supervisor**: Professor António Travassos
- **Tools and Libraries**: OpenCV, YOLO, WhisperV3, ChatGPT-4, Flask, Node.js

## License
This project is licensed under the MIT License. Feel free to use, modify, and distribute the code as per the license terms.

