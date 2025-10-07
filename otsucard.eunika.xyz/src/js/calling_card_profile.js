let qrText = window.location.href;
let labelText = $('.profile-fullname').text();

// Generate QR
new QRCode(document.getElementById("qrcode"), {
    text: qrText,
    width: 200,
    height: 200,
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
});

// Click event sa container
document.getElementById("qrcode").addEventListener("click", function () {
    let qrCanvas = document.querySelector("#qrcode canvas");

    // Fallback kung image ang output
    if (!qrCanvas) {
        let img = document.querySelector("#qrcode img");
        let tempCanvas = document.createElement("canvas");
        let ctx = tempCanvas.getContext("2d");
        tempCanvas.width = img.width;
        tempCanvas.height = img.height;
        ctx.drawImage(img, 0, 0);
        qrCanvas = tempCanvas;
    }

    let qrSize = qrCanvas.width;
    let padding = 16;
    let textHeight = 30;

    // Final canvas dimensions (QR + text + padding)
    let finalCanvas = document.createElement("canvas");
    finalCanvas.width = qrSize + (padding * 2);
    finalCanvas.height = qrSize + textHeight + (padding * 2);
    let ctx = finalCanvas.getContext("2d");

    // White background
    ctx.fillStyle = "#ffffff";
    ctx.fillRect(0, 0, finalCanvas.width, finalCanvas.height);

    // Draw QR
    ctx.drawImage(qrCanvas, padding, padding);

    // Draw label text
    ctx.font = "16px Arial";
    ctx.textAlign = "center";
    ctx.fillStyle = "#000";
    ctx.fillText(labelText, finalCanvas.width / 2, qrSize + padding + 20);

    // Download
    let link = document.createElement("a");
    link.href = finalCanvas.toDataURL("image/png");
    link.download = labelText + ".png";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
});

$(document).on("click", "#saveContactBtn", function () {
    // escape fields if null
    let name = UPD.card.fullname || "No Name";
    let phone = UPD.card.mobile_number || "";
    let email = UPD.user.email || "";

    // proper vCard format
    let vcard =
        "BEGIN:VCARD\r\n" +
        "VERSION:3.0\r\n" +
        `FN:${name}\r\n` +
        `TEL;TYPE=CELL:${phone}\r\n` +
        `EMAIL;TYPE=INTERNET:${email}\r\n` +
        "END:VCARD\r\n";

    let blob = new Blob([vcard], { type: "text/vcard;charset=utf-8" });
    let url = window.URL.createObjectURL(blob);

    let a = document.createElement("a");
    a.href = url;
    a.download = `${name}.vcf`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);

    window.URL.revokeObjectURL(url);
});
