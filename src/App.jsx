import React from "react";
import { BrowserRouter as Router, Routes, Route, Link } from "react-router-dom";
import Home from "./Home";
import Services from "./Services";
import Trekking from "./Trekking";
import TrekkingDetails from "./TrekkingDetails";
import GroupTrips from "./GroupTrips"; // ✅ NEW: Import group trip component

const App = () => {
  return (
    <Router>
      {/* NAVBAR always visible */}
      <header className="navbar">
        <div className="logo"><img src="logoo.jpg" width="16%" alt="" /></div>
        <nav className="nav-links">
          <Link to="/">Home</Link>
          <Link to="/services">Services</Link>
          <Link to="#">Blog</Link>
          <Link to="#">Contact</Link>
          <Link to="#">Login</Link>
        </nav>
      </header>

      {/* Only main content changes */}
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/services" element={<Services />} />
        <Route path="/trekking" element={<Trekking />} />
        <Route path="/trekking/:id" element={<TrekkingDetails />} />
        <Route path="/group-trips" element={<GroupTrips />} /> {/* ✅ NEW route */}
      </Routes>
    </Router>
  );
};

export default App;
