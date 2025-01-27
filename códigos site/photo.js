const { exec } = require('child_process');
const command = process.argv[2];

exec(command, (error, stdout, stderr) => {
    if (error) {
        console.error(`exec error: ${error}`);
        process.exit(1);
    }
    //console.log(`stdout: ${stdout}`);
    console.error(`stderr: ${stderr}`);
    process.exit(0);
});