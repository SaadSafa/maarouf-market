
window.getUserLocation = async function () {
  const res = await fetch("http://ip-api.com/json/");
  const data = await res.json();
   document.getElementById('UserArea').value = data.country + ', ' + data.city + ', ' +data.regionName;
};

document.addEventListener('DOMContentLoaded', () => {
  getUserLocation();
});
