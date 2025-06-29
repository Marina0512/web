$(document).ready(function () {
    $("#ipForm").submit(function (event) {
        event.preventDefault();
      var ipAddress = $("#ip").val();
      var apiUrl = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address?ip=";
      var token = "141c19083eafa8e2966a20e915aa99bd9feba2c0";
      var requestData = { ip: ipAddress };
  
      $.ajax({
        type: "POST",
        url: apiUrl,
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Token " + token
          },
        data: JSON.stringify(requestData),
        dataType: "json",
        encode: true,
      }).done(function (result) {
        console.log(result);
      });
  });

  if (result && result.location) {
    var city = result.location.data.city || "Не определен";
    var region = result.location.data.region || "Не определен";
    var country = result.location.data.country || "Не определен";

    var locationInfo = "Город: " + city + "<br>" +
                           "Регион: " + region + "<br>" +
                           "Страна: " + country;

 $("#locationInfo").html(locationInfo);
    } else {                       
 $("#locationInfo").html("Местоположение не определено.");
    }
  
    fail(function (jqXHR, textStatus, errorThrown) {
    console.error("Ошибка DaData API:", textStatus, errorThrown);
    $("#locationInfo").html("Ошибка при определении местоположения.");
    console.log("jqXHR:", jqXHR);
   });
 });