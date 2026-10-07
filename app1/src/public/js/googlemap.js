let map
let geocoder

function initMap(){

  geocoder = new google.maps.Geocoder()

  if(document.getElementById('map')){

    map = new google.maps.Map(document.getElementById('map'), {
      center: { lat: 35.6594666, lng: 139.7005536 },
      zoom: 15,
    })

  } else {

    map = new google.maps.Map(document.getElementById('show_map'), {
      center: { lat: LAT, lng: LNG },
      zoom: 15,
    })

    new google.maps.Marker({
      position: { lat: LAT, lng: LNG },
      map: map
    })
  }
}

function codeAddress() {

    let inputAddress = document.getElementById('address').value

    console.log(inputAddress)

    geocoder.geocode(
        { address: inputAddress },
        function(results, status) {

            console.log('status:', status)
            console.log(results)

            if (status === 'OK') {

                let lat = results[0].geometry.location.lat()
                let lng = results[0].geometry.location.lng()

                console.log('lat:', lat)
                console.log('lng:', lng)

                let latitudeInput = document.getElementById('latitude')
                let longitudeInput = document.getElementById('longitude')

                console.log(latitudeInput)
                console.log(longitudeInput)

                latitudeInput.value = lat
                longitudeInput.value = lng

                console.log(latitudeInput.value)
                console.log(longitudeInput.value)

                map.setCenter(results[0].geometry.location)

            } else {

                console.log('geocode failed')

                alert('住所検索に失敗しました')

            }

        }
    )
}