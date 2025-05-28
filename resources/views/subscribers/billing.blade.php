
<style>
  .bills .billing-container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .bills h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    .bills label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    .bills input, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .bills .form-group {
      margin-bottom: 15px;
    }
    .bills .checkbox-group {
      display: flex;
      align-items: center;
      margin-top: 10px;
    }
    .bills .checkbox-group input {
      width: auto;
      margin-right: 10px;
    }
    .bills button {
      width: 100%;
      background-color: #007bff;
      color: white;
      border: none;
      padding: 12px;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
    }
    .bills button:hover {
      background-color: #0056b3;
    }

    @media (max-width: 600px) {
      .bills .billing-container {
        padding: 15px;
      }
    }

</style>

<x-layout>

   <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Requests</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="/">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/">Home</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="/billing">Billing</a>
                </li>
              </ul>
            </div>
            <div class="row bills">
       
            <div class="billing-container">
    <h2>Billing</h2>

    <!-- Plan Details -->
    <div class="form-group">
      <label for="plan">Plan Details</label>
      <select id="plan">
        <option value="">-- Select Plan --</option>
        <option value="basic">Basic - $9.99/month</option>
        <option value="pro">Pro - $19.99/month</option>
        <option value="enterprise">Enterprise - $49.99/month</option>
      </select>
    </div>

    <!-- Billing Info -->
    <div class="form-group">
      <label for="name">Billing Name</label>
      <input type="text" id="name" placeholder="Full Name">
    </div>

    <div class="form-group">
      <label for="address">Billing Address</label>
      <input type="text" id="address" placeholder="Street, City, Zip">
    </div>

    <!-- Payment Options -->
    <div class="form-group">
      <label for="payment">Payment Method</label>
      <select id="payment">
        <option value="">-- Select Payment Method --</option>
        <option value="card">Credit/Debit Card</option>
        <option value="paypal">PayPal</option>
        <option value="upi">UPI</option>
      </select>
    </div>

    <!-- Recurring Option -->
    <div class="checkbox-group">
      <input type="checkbox" id="recurring">
      <label for="recurring">Enable Recurring Payment</label>
    </div>

    <button onclick="submitBilling()">Explore All Plans</button>
  </div>



            </div>
          </div>
   </div>


   <script>
    function submitBilling() {
      const plan = document.getElementById("plan").value;
      const name = document.getElementById("name").value;
      const address = document.getElementById("address").value;
      const payment = document.getElementById("payment").value;
      const recurring = document.getElementById("recurring").checked;

      if (!plan || !name || !address || !payment) {
        alert("Please fill out all fields.");
        return;
      }

      alert(`Plan: ${plan}\nName: ${name}\nAddress: ${address}\nPayment: ${payment}\nRecurring: ${recurring ? 'Yes' : 'No'}`);
    }
  </script>
</x-layout>