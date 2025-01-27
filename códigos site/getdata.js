const os = require('os');
const fs = require('fs');
const { execSync } = require('child_process');

function getMemoryUsage() {
    try {
        const output = execSync('free -m').toString('utf-8');
        const lines = output.trim().split('\n');
        const memoryLine = lines[1];
        const memoryValues = memoryLine.split(/\s+/);

        const totalMemory = parseInt(memoryValues[1]);
        const usedMemory = parseInt(memoryValues[2]);
        const memoryUsage = Math.round((usedMemory / totalMemory) * 100);

        return memoryUsage;
    } catch (error) {
        console.error('Error retrieving memory usage:', error);
        return -1;
    }
}

function getCpuUsage() {
    try {
        const output = execSync('mpstat 1 1').toString('utf-8');
        const lines = output.trim().split('\n');
        const lastLine = lines[lines.length - 1];
        const cpuUsage = lastLine.split(/\s+/)[2];

        return parseFloat(cpuUsage);
    } catch (err) {
        console.error('Error:', err);
    }
}



function getCpuTemperature() {
    try {
        const temperatureData = fs.readFileSync('/sys/class/thermal/thermal_zone0/temp', 'utf8').trim();
        const temperature = parseInt(temperatureData) / 1000; // Convert temperature from millidegrees Celsius to degrees Celsius
        return temperature;
    } catch (error) {
        return null;
    }
}

module.exports = {
    getMemoryUsage,
    getCpuUsage,
    getCpuTemperature
};
