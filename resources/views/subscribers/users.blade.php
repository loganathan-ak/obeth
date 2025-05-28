
<style>


#userModal input, select {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 100%;
  margin-bottom: 15px;
}

#userModal button {
  padding: 10px 15px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  width: 100%;
}

#userModal button:hover {
  background-color: #0056b3;
}

#userModal table {
  width: 100%;
  border-collapse: collapse;
}

#userModal table th, table td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: center;
}

#userModal table th {
  background-color: #343a40;
  color: white;
}



.users h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    .users form {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
      margin-bottom: 30px;
    }

    .users input, select {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .users button {
      padding: 10px 15px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: auto;
      width: fit-content;
    }

    .users button:hover {
      background-color: #0056b3;
    }

    .users table {
      width: 100%;
      border-collapse: collapse;
    }

    .users table th, table td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: center;
    }

    .users table th {
      background-color: #343a40;
      color: white;
    }

    .users .remove-btn {
      background-color: #dc3545;
    }

    .users .remove-btn:hover {
      background-color: #a71d2a;
    }

    .users .edit-btn {
      background-color: #28a745;
    }

    .users .edit-btn:hover {
      background-color: #218838;
    }

    @media (max-width: 768px) {
      .users .container {
        padding: 20px;
      }
    .users form {
        grid-template-columns: 1fr;
      }
    }


</style>
<x-layout>
<div class="container-fluid mt-5 pt-4 mb-5 pb-5">
  <div class="page-inner">
  <div class="page-header">
      <h3 class="fw-bold mb-3">Users</h3>
      <ul class="breadcrumbs mb-3">
        <li class="nav-home">
          <a href="/">
            <i class="fas fa-house"></i>
          </a>
        </li>
        <li class="separator">
          <i class="fa-solid fa-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="/">Home</a>
        </li>
        <li class="separator">
          <i class="fa-solid fa-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="/users">Users</a>
        </li>
      </ul>
    </div>

            <div class="row card p-4">
       

            <div class="users">
    <h2>Manage Users (User Role)</h2>

    <!-- Add User Form -->
     <div class="pt-2 pb-2" style="    justify-self: right;">
    <button class="btn-add-user" id="openModalBtn">Add User</button>
  </div>

    <!-- Users Table -->
    <table>
      <thead>
        <tr>
          <th>Full Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Role</th>
          <th>Created Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="userTableBody">
        <!-- User rows go here -->
      </tbody>
    </table>
  </div>


            </div>


  <!-- Modal -->
  <div id="userModal" class="modal">
      <div class="modal-content">
        <span class="close" id="closeModalBtn">&times;</span>
        <h3>Add User</h3>
        <form id="userForm">
          <input type="text" id="fullName" placeholder="Full Name" required />
          <input type="email" id="email" placeholder="Email Address" required />
          <input type="tel" id="phone" placeholder="Phone Number" required />
          <select id="role" required>
            <option value="">Select Role</option>
            <option value="User">User</option>
            <option value="Admin">Admin</option>
          </select>
          <button type="submit" class="mt-3">Add User</button>
        </form>
      </div>
    </div>


          </div>
   </div>



   <script>
    // JavaScript to handle modal pop-up and user management
    const userList = [];
    let currentEditIndex = null;  // To store the index of the user being edited

    // Get modal elements
    const modal = document.getElementById("userModal");
    const openModalBtn = document.getElementById("openModalBtn");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const userForm = document.getElementById("userForm");

    // Show the modal when "Add User" button is clicked
    openModalBtn.onclick = function () {
      modal.style.display = "block";
      currentEditIndex = null; // Reset to add new user
    };

    // Close the modal when "x" is clicked
    closeModalBtn.onclick = function () {
      modal.style.display = "none";
    };

    // Close the modal when clicked outside of the modal content
    window.onclick = function (event) {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    };

    // Handle user form submission
    userForm.addEventListener("submit", function (e) {
      e.preventDefault();

      const fullName = document.getElementById("fullName").value;
      const email = document.getElementById("email").value;
      const phone = document.getElementById("phone").value;
      const role = document.getElementById("role").value;

      const newUser = {
        fullName,
        email,
        phone,
        role,
        date: new Date().toLocaleDateString(),
      };

      if (currentEditIndex !== null) {
        // Edit existing user
        userList[currentEditIndex] = newUser;
      } else {
        // Add new user
        userList.push(newUser);
      }

      renderUsers();
      modal.style.display = "none"; // Close the modal
      userForm.reset(); // Reset form fields
    });

    // Render user list in the table
    function renderUsers() {
      const tbody = document.getElementById("userTableBody");
      tbody.innerHTML = "";

      userList.forEach((user, index) => {
        const row = `
          <tr>
            <td>${user.fullName}</td>
            <td>${user.email}</td>
            <td>${user.phone}</td>
            <td>${user.role}</td>
            <td>${user.date}</td>
            <td>
              <button class="edit-btn" onclick="editUser(${index})">Edit</button>
              <button class="remove-btn" onclick="removeUser(${index})">Remove</button>
            </td>
          </tr>
        `;
        tbody.innerHTML += row;
      });
    }

    // Remove user from the list
    function removeUser(index) {
      if (confirm("Are you sure you want to remove this user?")) {
        userList.splice(index, 1);
        renderUsers();
      }
    }

    // Edit user functionality
    function editUser(index) {
      const user = userList[index];
      currentEditIndex = index; // Store the index of the user being edited

      // Pre-fill the modal with the user details
      document.getElementById("fullName").value = user.fullName;
      document.getElementById("email").value = user.email;
      document.getElementById("phone").value = user.phone;
      document.getElementById("role").value = user.role;

      modal.style.display = "block"; // Open the modal
    }

    // Optional: preload with sample users
    userList.push({
      fullName: "Jane Doe",
      email: "jane@obethgraphics.com",
      phone: "9876543210",
      role: "User",
      date: "2025-04-30",
    });

    renderUsers();
  </script>

</x-layout>