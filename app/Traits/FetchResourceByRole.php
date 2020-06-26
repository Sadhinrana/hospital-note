<?php

namespace App\Traits;

use App\Appointment;
use App\Service;
use App\Room;
use App\User;

trait FetchResourceByRole
{
    /**
     * Fetch patients by role.
     *
     * @param void
     * @return \Illuminate\Support\Collection
     */
    function fetchPatientsByRole()
    {
        if (auth()->user() != null && isset(auth()->user()->company->company)) {
            auth()->user()->company = auth()->user()->company->company;
        }

        // check user role
        if (auth()->user()->role_id == 5) {
            $patients = User::where(['id' => auth()->id()])->get();
        } elseif (auth()->user()->role_id == 3) {
            if (count(auth()->user()->companies)) {
                if (auth()->user()->role->role_type == 3) {
                    $patients = User::where(['role_id' => 5, 'user_id' => auth()->id()])->get();
                } else {
                    $patients = User::where('role_id', 5)->whereIn('user_id', auth()->user()->companies->first()->users->pluck('id'))->get();
                }
            } else {
                $patients = User::where(['role_id' => 5, 'user_id' => auth()->id()])->get();
            }
        } elseif (auth()->user()->role_id == 4) {
            if (count(auth()->user()->companies)) {
                $patients = User::where('role_id', 5)->whereIn('user_id', auth()->user()->companies->first()->users->pluck('id'))->get();
            } else {
                $patients = collect();
            }
        } elseif (auth()->user()->role_id == 6) {
            $patients = User::where('role_id', 5)->whereIn('user_id', auth()->user()->company->users->pluck('id'))->get();
        } else {
            $patients = User::where('role_id', 5)->get();
        }

        return $patients;
    }

    /**
     * Fetch appointments by role.
     *
     * @param void
     * @return \Illuminate\Support\Collection
     */
    function fetchAppointmentsByRole()
    {
        if (auth()->user() != null && isset(auth()->user()->company->company)) {
            auth()->user()->company = auth()->user()->company->company;
        }

        // check user role
        if (auth()->user()->role_id == 5) {
            $appointments = auth()->user()->appointments;
        } elseif (auth()->user()->role_id == 3) {
            if (count(auth()->user()->companies)) {
                $appointments = Appointment::where(function ($q) {
                    if (auth()->user()->role_type != 3) {
                        $q->whereIn('doctor_id', auth()->user()->companies->first()->users->pluck('id'));
                    } else {
                        $q->where('doctor_id', auth()->user()->id);
                    }
                })
                    ->get();
            } else {
                $appointments = Appointment::where('doctor_id', auth()->user()->id)->get();
            }
        } elseif (auth()->user()->role_id == 4) {
            if (count(auth()->user()->companies)) {
                $appointments = auth()->user()->companies->first()->users->map->doctorAppointments->collapse();
            } else {
                $appointments = collect();
            }
        } elseif (auth()->user()->role_id == 6) {
            $appointments = auth()->user()->company->users->map->doctorAppointments->collapse();
        } else {
            $appointments = User::with('appointments')->get()->map->appointments->collapse();
        }

        return $appointments;
    }

    /**
     * Fetch users by role.
     *
     * @param void
     * @return \Illuminate\Support\Collection
     */
    function fetchUsersByRole()
    {
        if (auth()->user() != null && isset(auth()->user()->company->company)) {
            auth()->user()->company = auth()->user()->company->company;
        }

        // check user role
        if (auth()->user()->role_id == 5) {
            if (auth()->user()->doctor) {
                if (count(auth()->user()->doctor->companies)) {
                    $users = auth()->user()->companies->first()->users;
                } else {
                    $users = User::where('role_id', '!=', 5)
                        ->where('role_id', '!=', 1)
                        ->where('role_id', '!=', 2)
                        ->where('role_id', '!=', 6)
                        ->where('availability', 1)
                        ->get();
                }
            } else {
                $users = User::where('role_id', '!=', 5)
                    ->where('role_id', '!=', 1)
                    ->where('role_id', '!=', 2)
                    ->where('role_id', '!=', 6)
                    ->where('availability', 1)
                    ->get();
            }
        } elseif (auth()->user()->role_id == 3) {
            if (count(auth()->user()->companies)) {
                $users = User::where(function ($q) {
                    if (auth()->user()->role_type != 3) {
                        $q->whereIn('id', auth()->user()->companies->first()->users->pluck('id'))->where('role_id', '!=', 6)->get();
                    } else {
                        $q->where('id', auth()->id());
                    }
                })->get();
            } else {
                $users = User::where('id', auth()->user()->id)->get();
            }
        } elseif (auth()->user()->role_id == 4) {
            if (count(auth()->user()->companies)) {
                $users = auth()->user()->companies->first()->users()->where('role_id', '!=', 6)->get();
            } else {
                $users = collect();
            }
        } elseif (auth()->user()->role_id == 6) {
            $users = auth()->user()->company->users()->where('role_id', '!=', 6)->get();
        } else {
            $users = User::whereNotIn('role_id', [1, 2, 5, 6])
                ->where('availability', 1)
                ->get();
        }

        return $users;
    }

    /**
     * Fetch users by role.
     *
     * @param void
     * @return \Illuminate\Support\Collection
     */
    function fetchAvailableDoctorsByRole()
    {
        if (auth()->user() != null && isset(auth()->user()->company->company)) {
            auth()->user()->company = auth()->user()->company->company;
        }

        // check user role
        if (auth()->user()->role_id == 5) {
            if (auth()->user()->doctor) {
                if (count(auth()->user()->doctor->companies)) {
                    $users = auth()->user()->doctor->companies->first()->users;
//                    $users = auth()->user()->companies->first()->users;
                } else {
                    $users = User::where('role_id', 3)
                        ->where('availability', 1)
                        ->get();
                }
            } else {
                $users = User::where('role_id', 3)
                    ->where('availability', 1)
                    ->get();
            }
        } elseif (auth()->user()->role_id == 3) {
            if (count(auth()->user()->companies)) {
                $users = User::where(function ($q) {
                    if (auth()->user()->role_type != 3) {
                        $q->whereIn('id', auth()->user()->companies->first()->users->pluck('id'))
                            ->where('role_id', 3)
                            ->where('availability', 1)
                            ->get();
                    } else {
                        $q->where('id', auth()->id());
                    }
                })->get();
            } else {
                $users = User::where('id', auth()->user()->id)->get();
            }
        } elseif (auth()->user()->role_id == 4) {
            if (count(auth()->user()->companies)) {
                $users = auth()->user()->companies->first()->users()
                    ->where('role_id', 3)
                    ->where('availability', 1)
                    ->get();
            } else {
                $users = collect();
            }
        } elseif (auth()->user()->role_id == 6) {
            $users = auth()->user()->company->users()
                ->where('role_id', 3)
                ->where('availability', 1)
                ->get();
        } else {
            $users = User::where('role_id', 3)
                ->where('availability', 1)
                ->get();
        }

        return $users;
    }

    /**
     * Fetch services by role.
     *
     * @param void
     * @return \Illuminate\Support\Collection
     */
    function fetchServicesByRole()
    {
        if (auth()->user() != null && isset(auth()->user()->company->company)) {
            auth()->user()->company = auth()->user()->company->company;
        }

        // check user role
        if (auth()->user()->role_id == 5) {
            if (auth()->user()->doctor) {
                if (count(auth()->user()->doctor->companies)) {
                    $services = Service::whereIn('user_id', auth()->user()->doctor->companies->first()->users->pluck('id'))
                        ->get();
                } else {
                    $services = Service::all();
                }
            } else {
                $services = Service::all();
            }
        } elseif (auth()->user()->role_id == 3) {
            if (count(auth()->user()->companies)) {
                $services = Service::where(function ($q) {
                    if (auth()->user()->role_type != 3) {
                        $q->whereIn('user_id', auth()->user()->companies->first()->users->pluck('id'));
                    } else {
                        $q->where('user_id', auth()->user()->id);
                    }
                })
                    ->get();
            } else {
                $services = Service::where('user_id', auth()->user()->id)->get();
            }
        } elseif (auth()->user()->role_id == 4) {
            if (count(auth()->user()->companies)) {
                $services = Service::whereIn('user_id', auth()->user()->companies->first()->users->pluck('id'))
                    ->get();
            } else {
                $services = collect();
            }
        } elseif (auth()->user()->role_id == 6) {
            $services = Service::whereIn('user_id', auth()->user()->companies->first()->users->pluck('id'))
                ->get();
        } else {
            $services = Service::all();
        }
        return $services;
    }

     /**
     * Fetch rooms by role.
     *
     * @param void
     * @return \Illuminate\Support\Collection
     */
    function fetchRoomsByRole()
    {
        if (auth()->user()->role_id == 6) {
          return  $rooms = Room::whereIn('user_id', auth()->user()->companies->first()->users->pluck('id'))
                ->get();
        } else{
            return  $rooms = Room::all();
        }
    }
}
