
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
                            <h5 class="card-title">Manage Students' Internship Process</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Students -->
                                <div class="col-xl-3 col-lg-6 col-md-6">
                                    <div class="card text-black mb-4" style="background-color:#f6dae4">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="text-black">Registrations</h6>
                                                    <h3 class="text-black mb-0">{{ $pendingRegistrationsCount }}</h3>
                                                </div>
                                                <i class="fas fa-list fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between" style="background-color:#011F9C">
                                            <a class="small text-white stretched-link" href="{{ route('advisor.internship.registrations') }}">See Registrations</a>
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
                                                    <h6 class="text-black">Consultation</h6>
                                                    <h3 class="text-black mb-0">{{ $advisorCount }}</h3>
                                                </div>
                                                <i class="fas fa-check fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between" style="background-color:#011F9C">
                                            <a class="small text-white stretched-link" href="{{ route('advisor.consultations.index') }}">Manage Consultation</a>
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
                                                    <h6 class="text-black">Approval</h6>
                                                    <h3 class="text-black mb-0">{{ $coordinatorCount ?? 4 }}</h3>
                                                </div>
                                                <i class="fas fa-check fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between" style="background-color:#011F9C">
                                            <a class="small text-white stretched-link" href="{{ route('list/users') }}?role=coordinator">Manage Approval</a>
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
                                                    <h6 class="text-black">Students</h6>
                                                    <h3 class="text-black mb-0">{{ $totalUsers ?? 24 }}</h3>
                                                </div>
                                                <i class="fas fa-user-graduate fa-2x"></i>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between" style="background-color:#011F9C">
                                            <a class="small text-white stretched-link" href="{{ route('list/users') }}">Manage Students</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xl-8 ">
                    <div class="card flex-fill comman-shadow">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <h5 class="card-title">Students</h5>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4 pb-2">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card card-table comman-shadow">
                                        <div class="card-body">
                                            <div class="table-responsive lesson">
                                                <table class="table table-striped table-hover table-bordered mb-0 align-middle">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>Student Name</th>
                                                            <th>Company</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(isset($studentsWithCompanies) && $studentsWithCompanies->count() > 0)
                                                            @foreach($studentsWithCompanies as $registration)
                                                                <tr>
                                                                    <td>{{ $registration->student->name ?? 'N/A' }}</td>
                                                                    <td>{{ $registration->company_name ?? 'N/A' }}</td>
                                                                    <td>
                                                                        <a href="{{ route('advisor.internship.registrations', $registration->student_id) }}" class="btn btn-info btn-sm">See Student</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="2">No students found.</td>
                                                            </tr>
                                                        @endif
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
    
                <div class="col-12 col-xl-4">
                    <div class="card flex-fill comman-shadow">
                        <div class="card-body">
                            <div id="calendar-doctor" class="calendar-container"></div>
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
