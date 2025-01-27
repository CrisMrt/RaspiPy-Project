const { getMemoryUsage, getCpuUsage, getCpuTemperature } = require('/var/www/html/teste/getdata.js');

const memoryUsage = getMemoryUsage();
const cpuUsage = getCpuUsage();
const cpuTemperature = getCpuTemperature();

console.log(memoryUsage, ",");
console.log(cpuUsage, ",");
console.log(cpuTemperature);
