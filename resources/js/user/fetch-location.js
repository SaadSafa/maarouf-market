
window.getUserLocation = async function () {
  const res = await fetch("http://ip-api.com/json/");
  const data = await res.json();
   document.getElementById('UserArea').value = data.country + ', ' + data.city + ', ' +data.regionName;
  console.log("Country:", data.country);
  console.log("Region:", data.regionName);
  console.log("City:", data.city);
  console.log("Lat:", data.lat, "Lng:", data.lon);
};

document.addEventListener('DOMContentLoaded', () => {
  getUserLocation();
});
