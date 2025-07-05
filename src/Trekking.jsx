import React from 'react';
import { useNavigate } from 'react-router-dom';
import './Trekking.css';

const trekkingData = [
  {
    id: 'everest',
    name: 'Everest Base Camp',
    image: 'https://media.istockphoto.com/id/695677904/photo/signpost-way-to-m-t-everest-b-c.jpg?s=612x612&w=0&k=20&c=pyRyMrU9DpfRZtjuCBpG0dv1azH_Z-g2EPkIo6hccng='
  },
  {
    id: 'annapurna',
    name: 'Annapurna Circuit',
    image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTI1HK6pO6jVxQNhuFMXLAXfPOMG4U17jRFGg&s'
  },
  {
    id: 'langtang',
    name: 'Langtang Valley',
    image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkYoxF_Uyis8_jZBUSALV6RHmQVuALqmNigQ&s'
  },
  {
    id: 'manaslu',
    name: 'Manaslu Circuit',
    image: 'https://www.nepalhightrek.com/wp-content/uploads/2023/10/Manaslu-Trek-in-September.jpg'
  },
  {
    id: 'ghorepani',
    name: 'Ghorepani Poon Hill',
    image: 'https://w0.peakpx.com/wallpaper/525/780/HD-wallpaper-ghorepani-poon-hill-trek-nepal-nature-mountain-travel.jpg'
  },
  {
    id: 'makalu',
    name: 'Makalu Base Camp',
    image: 'https://media.nepaltrekadventures.com/uploads/img/makalu-base-camp-route.webp'
  },
  {
    id: 'kanchenjunga',
    name: 'Kanchenjunga Trek',
    image: 'https://i.ytimg.com/vi/xu7zh13Vzjo/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLBa9wN-OcA8gTMdLktU7p2jCCQ6yA'
  },
  {
    id: 'uppermustang',
    name: 'Upper Mustang',
    image: 'https://www.shutterstock.com/shutterstock/videos/3704776631/thumb/1.jpg?ip=x480'
  },
  {
    id: 'rolwaling',
    name: 'Rolwaling Trek',
    image: 'https://www.nepalsanctuarytreks.com/wp-content/uploads/2025/04/f9e52c40-eeb7-4374-8b0c-f63c764cb4f3-1-1.jpeg'
  },
  {
    id: 'dolpo',
    name: 'Upper Dolpo',
    image: 'https://media.istockphoto.com/id/1464694001/photo/drone-shot-of-phoksundo-lake-surrounded-by-mounts-in-shey-phoksundo-national-park-ringmo-nelap.jpg?s=612x612&w=0&k=20&c=suJg2KLcEH45kw1gaFAo28gnfBCXqAp97fFK5MEKBtM='
  },
];

function Trekking() {
  const navigate = useNavigate();

  const handlePlaceClick = (id) => {
    navigate(`/trekking/${id}`);
  };

  return (
    <div className="trekking-container">
      <h2>Trekking Destinations</h2>
      <div className="trekking-grid">
        {trekkingData.map((place) => (
          <div
            className="trekking-card"
            key={place.id}
            onClick={() => handlePlaceClick(place.id)}
          >
            <img src={place.image} alt={place.name} />
            <h3>{place.name}</h3>
          </div>
        ))}
      </div>
    </div>
  );
}

export default Trekking;
