const { getMemoryUsage, getCpuUsage, getCpuTemperature } = require('/var/www/html/teste/getdata.js');

const memoryUsage = getMemoryUsage();
const cpuUsage = getCpuUsage();
const cpuTemperature = getCpuTemperature();

console.log('Memory Usage:', memoryUsage, '%');
console.log('CPU Usage:', cpuUsage, '%');
console.log('CPU Temperature:', cpuTemperature, '°C');
