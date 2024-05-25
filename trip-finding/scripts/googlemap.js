function initMap() {
    const selector = document.getElementById("map")
    const center = { lat: 48.8589466, lng: 2.2769956 }
    const options = {
      center: center,
      zoom : 8,
    }
  
    const map = new google.maps.Map(selector, options);
  
    const marker = new google.maps.Marker({
      position: center,
      map: map,
    });
  }