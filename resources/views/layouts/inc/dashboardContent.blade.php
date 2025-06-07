@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
  <!-- Header Section -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="font-weight-bolder text-dark mb-0">PT GIKOKO KOGYO INDONESIA</h4>
          <p class="text-sm text-muted mb-0">Dashboard Overview</p>
        </div>
        <div class="d-flex align-items-center">
          <span class="text-sm text-muted me-3">{{ date('d M Y') }}</span>
        </div>
      </div>
    </div>
  </div>
      
    <!-- Main Content Area -->
    <div class="col-lg-10 col-md-9">
      <div class="row">
        <!-- Ringkasan Aktivitas -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card h-100">
            <div class="card-header pb-0">
              <h6 class="mb-0">Ringkasan Aktivitas</h6>
            </div>
            <div class="card-body text-center">
              <div class="display-4 font-weight-bold text-primary mb-2">{{ $totalOrders ?? 0 }}</div>
              <p class="text-sm text-muted mb-0">Total Pesanan</p>
            </div>
          </div>
        </div>

        <!-- Status Pesanan -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card h-100">
            <div class="card-header pb-0">
              <h6 class="mb-0">Status Pesanan</h6>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-sm">Pending</span>
                <span class="badge bg-gradient-warning">{{ $pendingOrders ?? 0 }}</span>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <span class="text-sm">Completed</span>
                <span class="badge bg-gradient-success">{{ $completedOrders ?? 0 }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Pesanan Terbaru -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card h-100">
            <div class="card-header pb-0">
              <h6 class="mb-0">Pesanan Terbaru</h6>
            </div>
            <div class="card-body p-2">
              <div class="table-responsive">
                <table class="table table-sm mb-0">
                  <thead>
                    <tr>
                      <th class="text-xs">Tracking</th>
                      <th class="text-xs">Harga</th>
                      <th class="text-xs">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($recentOrders ?? [] as $order)
                    <tr>
                      <td class="text-xs">{{ $order->tracking_no }}</td>
                      <td class="text-xs">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                      <td>
                        @if($order->status == '0')
                          <span class="badge badge-sm bg-gradient-warning">Pending</span>
                        @else
                          <span class="badge badge-sm bg-gradient-success">Completed</span>
                        @endif
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="3" class="text-center text-xs text-muted">Tidak ada pesanan</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="card h-100">
            <div class="card-header pb-0">
              <h6 class="mb-0">Total Pendapatan</h6>
            </div>
            <div class="card-body text-center">
              <div class="h4 font-weight-bold text-success mb-2">
                Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
              </div>
              <p class="text-sm text-muted mb-0">Total dari semua pesanan</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Detailed Orders Table -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Semua Pesanan</h6>
                  <p class="text-sm mb-0">
                    <i class="fa fa-check text-info" aria-hidden="true"></i>
                    <span class="font-weight-bold ms-1">{{ $completedOrders ?? 0 }} selesai</span> dari {{ $totalOrders ?? 0 }} pesanan
                  </p>
                </div>
                <div class="col-lg-6 col-5 my-auto text-end">
                  <div class="dropdown float-lg-end pe-4">
                    <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-ellipsis-v text-secondary"></i>
                    </a>
                    <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                      <li><a class="dropdown-item border-radius-md" href="{{ url('orders') }}">Lihat Semua Pesanan</a></li>
                      <li><a class="dropdown-item border-radius-md" href="{{ url('admin/completed-orders') }}">Pesanan Selesai</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tracking Number</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Price</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($orders ?? [] as $item)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ $item->tracking_no }}</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Rp {{ number_format($item->total_price, 0, ',', '.') }}</h6>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle text-center text-sm">
                        @if($item->status == '0')
                          <span class="badge badge-sm bg-gradient-warning">Pending</span>
                        @else
                          <span class="badge badge-sm bg-gradient-success">Completed</span>
                        @endif
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold">{{ $item->created_at->format('d M Y') }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <a href="{{ url('admin/view-order/'.$item->id) }}" class="btn btn-sm btn-outline-primary">
                          <i class="material-icons">visibility</i> View
                        </a>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="5" class="text-center">
                        <div class="d-flex flex-column justify-content-center align-items-center py-4">
                          <i class="material-icons text-muted" style="font-size: 48px;">inbox</i>
                          <h6 class="text-muted mt-2">Belum ada pesanan</h6>
                          <p class="text-sm text-muted">Pesanan akan muncul di sini setelah dibuat</p>
                        </div>
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection