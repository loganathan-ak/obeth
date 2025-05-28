


<x-layout>
<div class="container-fluid mt-5 pt-4 mb-5 pb-5">
  <div class="page-inner">
  <div class="page-header">
      <h3 class="fw-bold mb-3">Usage</h3>
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
          <a href="/usage">Usage</a>
        </li>
      </ul>
    </div>


    <div class="usage-card terms">
  <div class="date-filter">
    <label for="month-year">Month/Year:</label>
    <select id="month-year" class="form-control">
      <option>Eg: July/2024</option>
    </select>
  </div>

  <div class="stats-buttons">
    <button class="stat-btn">Total Credits (25)</button>
    <button class="stat-btn">Used Credits (22)</button>
    <button class="stat-btn">Total Orders (15)</button>
    <button class="stat-btn">Rush Requests (3)</button>
  </div>

  <div class="order-summary">
    <h3>Order Summary:</h3>

    <div class="order-card">
      <p><strong class="pe-3">Order ID#11245:</strong> Logo Design (Lion Logo New) - <span class="ps-3 completed">Completed</span></p>
      <p>Credit Used: 1 | Rush Request: 1</p>
      <button class="small-btn">Project Overview</button>
      <button class="small-btn">Project Files</button>
    </div>

    <div class="order-card">
      <p><strong class="pe-3">Order ID#11276:</strong> Business Card (TCS Business Card) - <span class="ps-3 in-progress">In Progress</span></p>
      <p>Credit Used: 2</p>
      <button class="small-btn">Project Overview</button>
      <button class="small-btn">Project Files</button>
    </div>

  </div>
</div>






  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
  const monthYearSelect = document.getElementById('month-year');
  const now = new Date();
  const currentMonth = now.getMonth(); // 0 - 11
  const currentYear = now.getFullYear();

  for (let i = 0; i < 12; i++) {
    const date = new Date(currentYear, currentMonth - i, 1);
    const month = date.toLocaleString('default', { month: 'long' });
    const year = date.getFullYear();
    const option = document.createElement('option');
    option.value = `${month}/${year}`;
    option.text = `${month}/${year}`;
    monthYearSelect.appendChild(option);
  }
});
</script>

</x-layout>