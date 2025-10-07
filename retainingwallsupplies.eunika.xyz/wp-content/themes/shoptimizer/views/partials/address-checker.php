<!DOCTYPE html>
<html>
<head>
    
    <?php

    $key = "AIzaSyBWbFzd1fNst0Ag3KT9ISwZEJzfEkzxxTg";

    ?>


    <title>Location Search with Google Places API</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $key; ?>&libraries=places"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        #search-container {
            margin-bottom: 20px;
        }
        #location-input {
            width: 70%;
            padding: 10px;
            font-size: 16px;
        }
        #search-button {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #4285F4;
            color: white;
            border: none;
            cursor: pointer;
        }
        #results {
            margin-top: 20px;
        }
        .place-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Location Search</h1>
    <div id="search-container">
        <input type="text" id="location-input" placeholder="Enter an address or location">
        <button id="search-button">Search</button>
    </div>
    <div id="results"></div>

    <script>
        // Replace with your actual Google API key
        const API_KEY = 'YOUR_API_KEY';
        
        document.getElementById('search-button').addEventListener('click', searchLocations);
        
        async function searchLocations() {
            const input = document.getElementById('location-input').value.trim();
            const resultsContainer = document.getElementById('results');
            
            if (!input) {
                resultsContainer.innerHTML = '<p>Please enter a location to search</p>';
                return;
            }
            
            resultsContainer.innerHTML = '<p>Searching...</p>';
            
            try {
                const places = await findPlaces(input);
                displayResults(places);
            } catch (error) {
                resultsContainer.innerHTML = `<p>Error: ${error.message}</p>`;
                console.error('Search error:', error);
            }
        }
        
        function findPlaces(query) {
            return new Promise((resolve, reject) => {
                if (!window.google || !window.google.maps || !window.google.maps.places) {
                    reject(new Error('Google Maps API not loaded'));
                    return;
                }
                
                const service = new google.maps.places.PlacesService(document.createElement('div'));
                
                const request = {
                    query: query,
                    fields: ['name', 'geometry', 'formatted_address', 'address_components', 'types']
                };
                
                service.textSearch(request, (results, status) => {
                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        const places = results.map(result => {
                            return {
                                name: result.name,
                                address: result.formatted_address,
                                location: {
                                    lat: result.geometry.location.lat(),
                                    lng: result.geometry.location.lng()
                                },
                                addressComponents: result.address_components,
                                types: result.types
                            };
                        });
                        resolve(places);
                    } else {
                        reject(new Error('Places API error: ' + status));
                    }
                });
            });
        }
        
        function displayResults(places) {
            const resultsContainer = document.getElementById('results');
            
            if (places.length === 0) {
                resultsContainer.innerHTML = '<p>No results found</p>';
                return;
            }
            
            let html = `<p>Found ${places.length} result(s):</p>`;
            
            places.forEach((place, index) => {
                const addressComponents = place.addressComponents.map(comp => {
                    return `${comp.long_name} (${comp.types.join(', ')})`;
                }).join(', ');
                
                html += `
                    <div class="place-item">
                        <h3>${index + 1}. ${place.name}</h3>
                        <p><strong>Address:</strong> ${place.address}</p>
                        <p><strong>Coordinates:</strong> ${place.location.lat}, ${place.location.lng}</p>
                        <p><strong>Address Components:</strong> ${addressComponents}</p>
                        <p><strong>Types:</strong> ${place.types.join(', ')}</p>
                    </div>
                `;
            });
            
            resultsContainer.innerHTML = html;
        }
    </script>
</body>
</html>