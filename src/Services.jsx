import React from 'react';
import { useNavigate } from 'react-router-dom';
import "./Services.css";

function Services() {
  const navigate = useNavigate();

  const handleTrekkingClick = () => {
    navigate('/trekking');
  };

  const handleGroupTripClick = () => {
    navigate('/group-trips');
  };

  return (
    <div>
      <section className="services-section">
        <div className="overlay">
          <div className="container">
            <h2>Our Services</h2>
            <div className="services-grid">
              <div
                className="service-card"
                onClick={handleTrekkingClick}
                style={{ cursor: 'pointer' }}
              >
                <img src="https://lp-cms-production.imgix.net/2025-05/shutterstock667066843-crop.jpg?auto=format,compress&q=72&w=1440&h=810&fit=crop" alt="Trekking" />
                <h3>Trekking Adventures</h3>
                <p>Experience breathtaking Himalayan trails with our expert-guided treks across Nepal.</p>
              </div>

              <div className="service-card">
                <img src="https://media-cdn.tripadvisor.com/media/photo-s/2e/0d/08/04/caption.jpg" alt="Booking" />
                <h3>Hotel & Transport Booking</h3>
                <p>We take care of your accommodation and travel with flexible booking options.</p>
              </div>

              <div
                className="service-card"
                onClick={handleGroupTripClick}
                style={{ cursor: 'pointer' }}
              >
                <img src="https://media.guruwalk.com/enzur0xu90wvwn5ytwgfps197mwo" alt="Group Trip" />
                <h3>Group Trip Organizer</h3>
                <p>Join fun travel groups or create your own for shared adventures and new friendships.</p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}

export default Services;
