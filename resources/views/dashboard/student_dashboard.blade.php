
@extends('layouts.master')
@section('content')
    {{-- message --}}
    {!! Toastr::message() !!}
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card shadow-sm p-3 d-flex flex-row align-items-center" 
                        style="background-color: #d0e3ff; border-left: 7px solid #334eac; border-bottom: 4px solid #334eac; border-radius: 20px; margin-bottom: 10px">
                        <div class="me-3" style="font-size: 1.8rem; color: #334eac;">
                            <i class="fas fa-sun"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-1" id="greetingText"></h3>
                            <span id="userName" data-name="{{ Session::get('name') }}"></span>
                            <p class="mb-0">How are you today?</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Internship Process</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Students -->
                                <div class="col-xl-3 col-lg-6 col-md-6">
                                    <div class="card text-black mb-4" style="background-color:#f6dae4">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="text-black">Registration</h6>
                                                    @if($registrationStatus === 'approved')
                                                        <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                    @else
                                                        <h3 class="text-black mb-0">{{ $studentCount ?? 1 }}</h3>
                                                    @endif
                                                </div>
                                                <i class="fas fa-file fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between" style="background-color:#011F9C">
                                            <a class="small text-white stretched-link" href="{{ route('internship.registration.create') }}">
                                            @if($registrationStatus === 'approved')
                                                View Registration
                                            @else
                                                Submit Registration
                                            @endif
                                            </a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Advisors -->
                                <div class="col-xl-3 col-lg-6 col-md-6">
                                    <div class="card text-black mb-4" style="background-color:#d4f0f7">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="text-black">Logbook Activity</h6>
                                                    <h3 class="text-black mb-0">{{ $logbookCount ?? 0 }}</h3>
                                                </div>
                                                <i class="fas fa-book fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between" style="background-color:#011F9C">
                                            <a class="small text-white stretched-link" href="{{ route('logbook.index') }}">Manage Logbook</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Coordinators -->
                                <div class="col-xl-3 col-lg-6 col-md-6" >
                                    <div class="card text-black mb-4" style="background-color:#d0d5f7">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="text-black">Consultation</h6>
                                                    <h3 class="text-black mb-0">{{ $consultationCount ?? 0 }}</h3>
                                                </div>
                                                <i class="fas fa-list fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between" style="background-color:#011F9C">
                                            <a class="small text-white stretched-link" href="{{ route('consultations.index') }}">Manage Consultation</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- All Users -->
                                <div class="col-xl-3 col-lg-6 col-md-6">
                                    <div class="card text-black mb-4" style="background-color:#b8cfec">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="text-black">Report Submission</h6>
                                                    <h3 class="text-black mb-0">{{ $totalUsers ?? 1 }}</h3>
                                                </div>
                                                <i class="fas fa-upload fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between" style="background-color:#011F9C">
                                            <a class="small text-white stretched-link" href="{{ route('list/users') }}">Submit Report</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateGreeting() {
            const greetingElement = document.getElementById("greetingText");
            const name = document.getElementById("userName").dataset.name;
            const now = new Date();
            const hour = now.getHours();
            let greeting;

            if (hour >= 5 && hour < 12) {
                greeting = "Good Morning";
            }
            else if (hour >= 12 && hour < 17) {
                greeting = "Good Afternoon";
            }
            else if (hour >= 17 && hour < 21) {
                greeting = "Good Evening";
            }
            else {
                greeting = "Good Night";
            }
            greetingElement.textContent = `${greeting}, ${name}!`;
        }
        document.addEventListener("DOMContentLoaded", updateGreeting);
    </script>
@endsection
