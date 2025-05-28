
<x-layout>
    <div class="container-fluid mt-5 pt-5 mb-5 pb-5">
      <div class="page-inner">
        <div
          class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
        >
          <div>
            <h3 class="fw-bold mb-3">Dashboard</h3>
            <h6 class="op-7 mb-2">Obeth Graphics Subscribers Dashboard</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                      {{-- <i class="fas fa-users"></i> --}}
                      <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M5 4a2 2 0 0 0-2 2v1h10.968l-1.9-2.28A2 2 0 0 0 10.532 4H5ZM3 19V9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm9-8.5a1 1 0 0 1 1 1V13h1.5a1 1 0 1 1 0 2H13v1.5a1 1 0 1 1-2 0V15H9.5a1 1 0 1 1 0-2H11v-1.5a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                      </svg>
                      
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-0">
                    <div class="numbers">
                      <p class="card-category">Total Orders</p>
                      <h4 class="card-title">14</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-info bubble-shadow-small"
                    >
                      {{-- <i class="fas fa-user-check"></i> --}}
                      <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M4 4a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2v14a1 1 0 1 1 0 2H5a1 1 0 1 1 0-2V5a1 1 0 0 1-1-1Zm5 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-1Zm-5 4a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H9Zm5 0a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1h-1Zm-3 4a2 2 0 0 0-2 2v3h2v-3h2v3h2v-3a2 2 0 0 0-2-2h-2Z" clip-rule="evenodd"/>
                      </svg>
                      
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-0">
                    <div class="numbers">
                      <p class="card-category">Admins</p>
                      <h4 class="card-title">10</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-success bubble-shadow-small"
                    >
                      {{-- <i class="fas fa-luggage-cart"></i> --}}
                      <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7.171 12.906-2.153 6.411 2.672-.89 1.568 2.34 1.825-5.183m5.73-2.678 2.154 6.411-2.673-.89-1.568 2.34-1.825-5.183M9.165 4.3c.58.068 1.153-.17 1.515-.628a1.681 1.681 0 0 1 2.64 0 1.68 1.68 0 0 0 1.515.628 1.681 1.681 0 0 1 1.866 1.866c-.068.58.17 1.154.628 1.516a1.681 1.681 0 0 1 0 2.639 1.682 1.682 0 0 0-.628 1.515 1.681 1.681 0 0 1-1.866 1.866 1.681 1.681 0 0 0-1.516.628 1.681 1.681 0 0 1-2.639 0 1.681 1.681 0 0 0-1.515-.628 1.681 1.681 0 0 1-1.867-1.866 1.681 1.681 0 0 0-.627-1.515 1.681 1.681 0 0 1 0-2.64c.458-.361.696-.935.627-1.515A1.681 1.681 0 0 1 9.165 4.3ZM14 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                      </svg>
                      
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-0">
                    <div class="numbers">
                      <p class="card-category">Users</p>
                      <h4 class="card-title">50</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-icon">
                    <div
                      class="icon-big text-center icon-secondary bubble-shadow-small"
                    >
                      <i class="far fa-check-circle"></i>
                    </div>
                  </div>
                  <div class="col col-stats ms-3 ms-sm-0">
                    <div class="numbers">
                      <p class="card-category">Completed</p>
                      <h4 class="card-title">18</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="card card-round">
              <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                  <div class="card-title">Transaction History</div>
                  <div class="card-tools">
                    <div class="dropdown">
                      <button
                        class="btn btn-icon btn-clean me-0"
                        type="button"
                        id="dropdownMenuButton"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        <i class="fas fa-ellipsis-h"></i>
                      </button>
                      <div
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuButton"
                      >
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#"
                          >Something else here</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <!-- Projects table -->
                  <table class="table align-items-center mb-0">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col">Payment Number</th>
                        <th scope="col" class="text-end">Date & Time</th>
                        <th scope="col" class="text-end">Amount</th>
                        <th scope="col" class="text-end">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">
                          <button
                            class="btn btn-icon btn-round btn-success btn-sm me-2"
                          >
                            <i class="fa fa-check"></i>
                          </button>
                          Payment from #10231
                        </th>
                        <td class="text-end">Mar 19, 2020, 2.45pm</td>
                        <td class="text-end">$250.00</td>
                        <td class="text-end">
                          <span class="badge badge-success">Completed</span>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">
                          <button
                            class="btn btn-icon btn-round btn-success btn-sm me-2"
                          >
                            <i class="fa fa-check"></i>
                          </button>
                          Payment from #10231
                        </th>
                        <td class="text-end">Mar 19, 2020, 2.45pm</td>
                        <td class="text-end">$250.00</td>
                        <td class="text-end">
                          <span class="badge badge-success">Completed</span>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">
                          <button
                            class="btn btn-icon btn-round btn-success btn-sm me-2"
                          >
                            <i class="fa fa-check"></i>
                          </button>
                          Payment from #10231
                        </th>
                        <td class="text-end">Mar 19, 2020, 2.45pm</td>
                        <td class="text-end">$250.00</td>
                        <td class="text-end">
                          <span class="badge badge-success">Completed</span>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">
                          <button
                            class="btn btn-icon btn-round btn-success btn-sm me-2"
                          >
                            <i class="fa fa-check"></i>
                          </button>
                          Payment from #10231
                        </th>
                        <td class="text-end">Mar 19, 2020, 2.45pm</td>
                        <td class="text-end">$250.00</td>
                        <td class="text-end">
                          <span class="badge badge-success">Completed</span>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">
                          <button
                            class="btn btn-icon btn-round btn-success btn-sm me-2"
                          >
                            <i class="fa fa-check"></i>
                          </button>
                          Payment from #10231
                        </th>
                        <td class="text-end">Mar 19, 2020, 2.45pm</td>
                        <td class="text-end">$250.00</td>
                        <td class="text-end">
                          <span class="badge badge-success">Completed</span>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">
                          <button
                            class="btn btn-icon btn-round btn-success btn-sm me-2"
                          >
                            <i class="fa fa-check"></i>
                          </button>
                          Payment from #10231
                        </th>
                        <td class="text-end">Mar 19, 2020, 2.45pm</td>
                        <td class="text-end">$250.00</td>
                        <td class="text-end">
                          <span class="badge badge-success">Completed</span>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">
                          <button
                            class="btn btn-icon btn-round btn-success btn-sm me-2"
                          >
                            <i class="fa fa-check"></i>
                          </button>
                          Payment from #10231
                        </th>
                        <td class="text-end">Mar 19, 2020, 2.45pm</td>
                        <td class="text-end">$250.00</td>
                        <td class="text-end">
                          <span class="badge badge-success">Completed</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-primary card-round">
              <div class="card-header">
                <div class="card-head-row">
                  <div class="card-title">Daily Sales</div>
                  <div class="card-tools">
                    <div class="dropdown">
                      <button
                        class="btn btn-sm btn-label-light dropdown-toggle"
                        type="button"
                        id="dropdownMenuButton"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        Export
                      </button>
                      <div
                        class="dropdown-menu"
                        aria-labelledby="dropdownMenuButton"
                      >
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#"
                          >Something else here</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-category">March 25 - April 02</div>
              </div>
              <div class="card-body pb-0">
                <div class="mb-4 mt-2">
                  <h1>$4,578.58</h1>
                </div>
                <div class="pull-in">
                  <canvas id="dailySalesChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          
        </div>
      </div>
    </div>
  </x-layout>