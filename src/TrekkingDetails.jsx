import React from 'react';
import { useParams } from 'react-router-dom';
import './TrekkingDetails.css';

const trekkingDetails = {
  everest: {
    name: 'Everest Base Camp',
    location: 'Solukhumbu, Nepal',
    cost: 'Rs. 150,000',
    duration: '14 Days',
    path: 'Lukla - Namche - Tengboche - Dingboche - Lobuche - Gorakshep - EBC',
    image: 'https://www.himalayanwonders.com/images/ebc-trek1.jpg'
  },
  annapurna: {
    name: 'Annapurna Circuit',
    location: 'Annapurna Region, Nepal',
    cost: 'Rs. 120,000',
    duration: '18 Days',
    path: 'Besisahar - Chame - Manang - Thorong La - Muktinath - Tatopani - Pokhara',
    image: 'https://www.thirdrockadventures.com/images/annapurna-circuit-trek.jpg'
  },
  langtang: {
    name: 'Langtang Valley',
    location: 'Rasuwa, Nepal',
    cost: 'Rs. 80,000',
    duration: '10 Days',
    path: 'Syabrubesi - Lama Hotel - Langtang Village - Kyanjin Gompa - Return',
    image: 'https://nepalhikingtrek.com/images/trek/langtang-valley-trek.jpg'
  },
  manaslu: {
    name: 'Manaslu Circuit',
    location: 'Gorkha, Nepal',
    cost: 'Rs. 130,000',
    duration: '16 Days',
    path: 'Soti Khola - Maccha Khola - Jagat - Deng - Samagaun - Larkya La - Bimthang',
    image: 'https://www.nepalhikingteam.com/images/ManasluCircuitTrek.jpg'
  },
  ghorepani: {
    name: 'Ghorepani Poon Hill',
    location: 'Myagdi, Nepal',
    cost: 'Rs. 40,000',
    duration: '5 Days',
    path: 'Nayapul - Tikhedhunga - Ghorepani - Poon Hill - Tadapani - Ghandruk',
    image: 'https://www.himalayastrek.com/wp-content/uploads/2019/03/poon-hill.jpg'
  },
  makalu: {
    name: 'Makalu Base Camp',
    location: 'Makalu Barun National Park, Nepal',
    cost: 'Rs. 140,000',
    duration: '20 Days',
    path: 'Num - Seduwa - Tashigaon - Khongma - MBC - Return',
    image: 'https://www.ekta-travel.com/wp-content/uploads/2020/06/Makalu-Base-Camp-Trek.jpg'
  },
  kanchenjunga: {
    name: 'Kanchenjunga Trek',
    location: 'Taplejung, Nepal',
    cost: 'Rs. 160,000',
    duration: '22 Days',
    path: 'Taplejung - Mitlung - Ghunsa - Pangpema - Return',
    image: 'https://www.adventureboundnepal.com/wp-content/uploads/2020/01/Kanchenjunga-Circuit-Trek.jpg'
  },
  uppermustang: {
    name: 'Upper Mustang',
    location: 'Mustang, Nepal',
    cost: 'Rs. 200,000',
    duration: '14 Days',
    path: 'Jomsom - Kagbeni - Lo Manthang - Return',
    image: 'https://www.himalayanmentor.com/uploads/upper-mustang-trek.jpg'
  },
  rolwaling: {
    name: 'Rolwaling Trek',
    location: 'Dolakha, Nepal',
    cost: 'Rs. 125,000',
    duration: '15 Days',
    path: 'Charikot - Beding - Na - Tso Rolpa - Tashi Lapcha Pass - Thame',
    image: 'https://www.outfitternepal.com/images/rolwaling-trekking.jpg'
  },
  dolpo: {
    name: 'Upper Dolpo',
    location: 'Dolpa, Nepal',
    cost: 'Rs. 180,000',
    duration: '21 Days',
    path: 'Jhupal - Dunai - Shey Gompa - Phoksundo - Return',
    image: 'https://www.himalayancompanion.com/wp-content/uploads/2020/03/Upper-Dolpo-Trek.jpg'
  }
};

function TrekkingDetails() {
  const { id } = useParams();
  const place = trekkingDetails[id];

  if (!place) {
    return <h2>Place not found</h2>;
  }

  const googleSearchQuery = place.path.replace(/ - /g, ' to ');
const mapUrl = `https://www.google.com/maps/embed/v1/directions?key=YOUR_ACTUAL_API_KEY&origin=...`;

  return (
    <div className="details-container">
      <img src={place.image} alt={place.name} className="details-banner" />
      <h2>{place.name}</h2>
      <p><strong>Location:</strong> {place.location}</p>
      <p><strong>Cost:</strong> {place.cost}</p>
      <p><strong>Duration:</strong> {place.duration}</p>
      <p><strong>Path:</strong> {place.path}</p>

      <div className="map-container">
        <h3>Route Map</h3>
        <iframe
          title="Route Map"
          width="100%"
          height="400"
          frameBorder="0"
          style={{ border: 0 }}
          src={mapUrl}
          allowFullScreen
        ></iframe>
      </div>
    </div>
  );
}

export default TrekkingDetails;
