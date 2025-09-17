
const downloadBadge = document.getElementById('dwnBadge');

let userId = document.getElementById("uuid").value;

      // Fetch user data from PHP as JSON
    fetch(`generate_qr.php?user_id=${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
                return;
            }
    let bioData = `Name: ${data.full_name}\nPhone: ${data.phone_number}\nEmail: ${data.email}\nDealer: ${data.dealer_name}\nState: ${data.state}\nLGA: ${data.lga}\nAddress: ${data.address}\nNIN: ${data.nin}`;
  $('#badge').css('display', 'block');
  $('#dwnBadge').css('display', 'block');
  $('#qrcode').qrcode({
    text: bioData,
    width: 128,
    height: 128
  });

  })
        .catch();

downloadBadge.addEventListener('click', function (e) {
  e.preventDefault();
  const badgeElement = document.getElementById('badge');
  htmlToImage.toPng(badgeElement)
    .then(function (dataUrl) {
      const link = document.createElement('a');
      link.download = 'AMDON ID CARD.png';
      link.href = dataUrl;
      link.click();
    })
    .catch(function (error) {
      console.error('Error converting HTML to image:', error);
    });

});