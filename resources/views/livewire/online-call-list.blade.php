<div wire:poll.10000ms>
    <div class="card" id="OnlineCallList">
        <div class="card-header border-bottom-dashed">
            <div class="row g-4 align-items-center">
                <div class="col-sm">
                    <h5 class="card-title mb-0">Online Call List (ALT + O )</h5>
                </div>
                <div class="col-sm-auto">
                    <button wire:click="toggleFilters" accesskey="S" title="ALT+S" class="btn btn-sm btn-secondary">
                        <i class="ri-filter-line align-bottom me-1"></i> {{ $showFilters ? 'Hide Filters' : 'Show Filters' }}
                    </button>
                    <a href="{{ route('online-calls.create') }}" accesskey="C" title="ALT+C" class="btn btn-sm btn-primary">
                        <i class="ri-add-line align-bottom me-1"></i> Add New
                    </a>
                </div>
            </div>
        </div>

        @if ($showFilters)
        <div class="card-body border border-dashed border-end-0 border-start-0">
            <form>
                <div class="row g-3">
                    <div class="col-xxl-4 col-sm-6">
                        <div class="search-box">
                            <input type="text" class="form-control form-control-sm search" placeholder="Search ..." wire:model="search">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endif

        <div class="card-body">
            <div class="table-responsive table-card mb-1">
                <table class="table align-middle" id="onsiteVisitTable">
                    <thead class="table-light text-muted">
                        <tr>
                            <th>S.No</th>
                            <th>Customer</th>
                            <th>Tally S.NO</th>
                            <th>Contact Person</th>
                            <th>Mobile Numbers</th>
                            <th>Type Of Call</th>
                            <th>Booking Date & Time</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Folow Up Date</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($onlineCalls as $index => $visit)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $visit->customer->customer_name }}</td>
                            <td>{{ $visit->customer->tally_serial_no }}</td>
                            <td>{{ $visit->contactPerson->contact_person }}</td>
                            <td>{{ $visit->contactPersonMobile->mobile_no }}</td>
                            <td>{{ $visit->type_of_call }}</td>
                            <td>{{ \Carbon\Carbon::parse($visit->call_booking_time)->format('d M h:i:s A') }}</td>
                            <td>{{ $visit->status_of_call }}</td>
                            <td>{{ $visit->assignedTo->name ?? 'N/A' }}</td>
                            <td>{{ $visit->follow_up_date ? \Carbon\Carbon::parse($visit->follow_up_date)->format('d M') : '' }}</td>
                            <td style="max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                @if(strlen($visit->remarks) > 50)
                                <marquee behavior="scroll" direction="left">{{ $visit->remarks }}</marquee>
                                @else
                                {{ $visit->remarks }}
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('online-calls.edit', $visit->id) }}" class="btn btn-sm btn-info">
                                    <i class="ri-edit-line align-bottom me-1"></i> Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
                <div class="d-flex justify-content-between">
                    <div style="margin-left: 20px;">Total Records: {{ $onlineCalls->total() }}</div>
                    <div style="margin-left: 20px;">{{ $onlineCalls->links() }}</div>
                </div>
            </div>
        </div>

    </div>
</div>