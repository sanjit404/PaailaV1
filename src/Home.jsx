import React, { useState } from "react";
import "./Home.css";

const Home = () => {
  const [showAbout, setShowAbout] = useState(false); // State toggle

  const toggleAbout = () => {
    setShowAbout(!showAbout); // Flip the state
  };

  return (
    <>
      <section className="hero">
        <div className="hero-content">
          <h1>Welcome to Pailaa Tour & Travels</h1>
          <p>Explore Nepal like never before — from Himalayas to heritage cities.</p>
          <button className="read-more-btn" onClick={toggleAbout}>
            {showAbout ? "Read Less" : "Read More"}
          </button>
        </div>
      </section>

      {showAbout && (
        <section className="about-section" id="about">
          <div className="overlay">
            <div className="container">
              <h2>About Pailaa</h2>
              <p>
                Pailaa Tour and Travels is your trusted guide to the breathtaking beauty and rich culture of Nepal.
                Founded by passionate trekkers and local explorers, we believe in journeys that create stories — from
                snow-capped peaks to ancient temples.
              </p>
              <p>
                Our mission is to connect people through memorable experiences, support local communities, and ensure
                every traveler leaves with a deeper understanding of Nepal's heritage and natural wonders.
              </p>
              <p>
                Whether you're planning a solo trek to Everest Base Camp, a peaceful retreat to Pokhara, or a spiritual
                visit to Lumbini, we walk with you — every step of the way.
              </p>
            </div>
          </div>
        </section>
      )}
    </>
  );
};

export default Home;
