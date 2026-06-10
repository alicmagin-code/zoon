const fs = require('fs');
const pdf = require('pdf-parse');

let dataBuffer = fs.readFileSync('Activities/zoon-objectives.pdf');

// Call the exported PDFParse function
pdf.PDFParse(dataBuffer).then(function(data) {
    fs.writeFileSync('Activities/extracted-text.txt', data.text);
    console.log("PDF parsed successfully. Characters:", data.text.length);
}).catch(err => {
    console.error("Error parsing PDF:", err);
});
