@extends('layouts.parent')

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <form method="POST" action="{{route('addPackage')}}">
                    @csrf
                    <div class="form-body">
                        <h4 class="font-medium">Add Package</h4>
                        <div class="card m-t-30">
                            <div class="card-content">
                                <div class="row m-t-20">
                                    <div class="col s12 m6 l6">
                                    <div class="input-field">
                                        <input name="package_name" placeholder="Enter package name" id="package_name" type="text" name="package_name" autocomplete="off" required>
                                        <label for="package_name">Package Name</label>
                                    </div>
                                    </div>
                                    <div class="col s12 m6 l6">
                                    <div class="input-field">
                                        <input name="package_price" id="package_price" type="number" step="any" placeholder="Enter package price in USD" autocomplete="off" required>
                                        <label for="package_price">Package Price <small>(USD)</small></label>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 m6 l6">
                                    <div class="input-field">
                                        <input name="work_type" id="work_type" type="text" placeholder="Enter work type e.g. Data Entry" autocomplete="off" required>
                                        <label for="work_type">Work Type</label>
                                    </div>
                                    </div>
                                    <div class="col s12 m6 l6">
                                    <div class="input-field">
                                        <input name="contract_period" id="contract_period" type="number" placeholder="Enter contract period in years e.g. 3" autocomplete="off" required>
                                        <label for="contract_period">Contract Period <small>(Years)</small></label>
                                    </div>
                                    </div>
                                </div>
                                <div class="row m-t 20">
                                    <div class="col s12">
                                    <div class="input-field">
                                        <input name="payment_task" id="payment_task" type="number" step="any" placeholder="Enter per task reward in USD"  autocomplete="off" required>
                                        <label for="payment_task">Per task reward</label>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                    <div class="input-field">
                                        <input name="total_task" id="total_task" type="number" step="any" placeholder="Enter maximum number of tasks per day" autocomplete="off" required>
                                        <label for="total_task">Maximum Number of Tasks</label>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                    <div class="input-field">
                                        <input name="com" id="com" type="number" step="any" placeholder="Referral Comission" autocomplete="off" required>
                                        <label for="com">Referral Comission ( % )</label>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                    <div class="input-field">
                                        <input name="tcom" id="tcom" type="number" step="any" placeholder="Referral Comission" autocomplete="off" required>
                                        <label for="tcom">Task Referral Comission ( % )</label>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="form-action">
                                        <button class="btn waves-effect waves-light cyan" type="submit" name="action">Save
                                        </button>
                                        <a href="/packages" class="btn waves-effect waves-light grey darken-4" name="action">Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection