import React, { useState } from "react";
import "./GroupTrips.css";

const isAdmin = true; // 👈 Later replace with actual auth

const initialGroups = [
  {
    id: "grp1",
    destination: "Everest Base Camp",
    leader: "Alice",
    members: [
      { name: "Alice", image: "https://randomuser.me/api/portraits/women/1.jpg" },
      { name: "Bob", image: "https://randomuser.me/api/portraits/men/2.jpg" },
      { name: "Charlie", image: "https://randomuser.me/api/portraits/men/3.jpg" }
    ]
  },
  {
    id: "grp2",
    destination: "Annapurna Circuit",
    leader: "David",
    members: [
      { name: "David", image: "https://randomuser.me/api/portraits/men/4.jpg" },
      { name: "Emma", image: "https://randomuser.me/api/portraits/women/5.jpg" }
    ]
  }
];

function GroupTrips() {
  const [groups, setGroups] = useState(initialGroups);
  const [newMember, setNewMember] = useState("");
  const [selectedGroupId, setSelectedGroupId] = useState(null);
  const [newMemberImage, setNewMemberImage] = useState("");
  const [newGroup, setNewGroup] = useState({
    destination: "",
    leader: "",
    leaderImage: ""
  });

  const handleAddMember = () => {
    if (!newMember || !selectedGroupId) return;

    setGroups(groups.map(group => {
      if (group.id === selectedGroupId && group.members.length < 10) {
        return {
          ...group,
          members: [...group.members, {
            name: newMember,
            image: newMemberImage || "https://via.placeholder.com/50"
          }]
        };
      }
      return group;
    }));

    setNewMember("");
    setNewMemberImage("");
    setSelectedGroupId(null);
  };

  const handleDeleteMember = (groupId, memberName) => {
    setGroups(groups.map(group => {
      if (group.id === groupId) {
        return {
          ...group,
          members: group.members.filter(m => m.name !== memberName)
        };
      }
      return group;
    }));
  };

  const handleCreateGroup = () => {
    if (!newGroup.destination || !newGroup.leader) return;

    const newId = `grp${Date.now()}`;
    const newEntry = {
      id: newId,
      destination: newGroup.destination,
      leader: newGroup.leader,
      members: [
        {
          name: newGroup.leader,
          image: newGroup.leaderImage || "https://via.placeholder.com/50"
        }
      ]
    };

    setGroups([...groups, newEntry]);

    setNewGroup({
      destination: "",
      leader: "",
      leaderImage: ""
    });
  };

  return (
    <div className="group-trips">
      <h2>Group Trip Organizer</h2>

      {isAdmin && (
        <div className="create-group-form">
          <h3>Create New Group</h3>
          <input
            type="text"
            placeholder="Destination"
            value={newGroup.destination}
            onChange={(e) =>
              setNewGroup({ ...newGroup, destination: e.target.value })
            }
          />
          <input
            type="text"
            placeholder="Group Leader Name"
            value={newGroup.leader}
            onChange={(e) =>
              setNewGroup({ ...newGroup, leader: e.target.value })
            }
          />
          <input
            type="text"
            placeholder="Leader Image URL (optional)"
            value={newGroup.leaderImage}
            onChange={(e) =>
              setNewGroup({ ...newGroup, leaderImage: e.target.value })
            }
          />
          <button onClick={handleCreateGroup}>Create Group</button>
        </div>
      )}

      <div className="group-list">
        {groups.map(group => (
          <div key={group.id} className="group-card">
            <h3>{group.destination}</h3>
            <p><strong>Group Leader:</strong> {group.leader} <span className="leader-tag">(group leader)</span></p>
            <p><strong>Members ({group.members.length}/10):</strong></p>
            <ol className="member-list">
              {group.members.map((member, i) => (
                <li key={i}>
                  <img src={member.image} alt={member.name} className="member-img" />
                  {member.name}
                  {isAdmin && member.name !== group.leader && (
                    <button className="delete-btn" onClick={() => handleDeleteMember(group.id, member.name)}>✕</button>
                  )}
                </li>
              ))}
            </ol>

            {isAdmin && group.members.length < 10 && (
              <div className="add-member-form">
                <input
                  type="text"
                  placeholder="Member name"
                  value={selectedGroupId === group.id ? newMember : ""}
                  onChange={(e) => {
                    setNewMember(e.target.value);
                    setSelectedGroupId(group.id);
                  }}
                />
                <input
                  type="text"
                  placeholder="Image URL (optional)"
                  value={selectedGroupId === group.id ? newMemberImage : ""}
                  onChange={(e) => {
                    setNewMemberImage(e.target.value);
                    setSelectedGroupId(group.id);
                  }}
                />
                <button onClick={handleAddMember}>Add</button>
              </div>
            )}
          </div>
        ))}
      </div>
    </div>
  );
}

export default GroupTrips;
