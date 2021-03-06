@extends('adminlte::page')

@section('content')

    <div class="panel panel-success" id="services-wrapper" style="display: none">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-4">
                <button onclick="goBack()" class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i> Back</button>
            </div>
            <div class="col-md-4">
                <strong>All Services</strong>
            </div>
            <div class="col-md-4">
                <a href="{{route('services.create')}}" class="btn btn-sm btn-primary btn-block"><i class="fa fa-plus"></i> Create New service</a>
            </div>
        </div>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-1">
                    <select v-model="params.perPage" class="form-control" @change="getServices()">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-md-5"></div>
                <div class="col-md-6">
                    <div class="pull-right">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="" class="pull-right">Search: </label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" v-model="params.keyword" class="form-control" @change="keyTyping" @keyup="keyTyping">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-hover table-striped table-custom" v-if="services.length > 0">
                <thead>
                    <tr>
                        <th @click="filterParam('sort', 'name')" :class="{ 'table-custom-header' : params.sort_by != 'name', 'sorting_asc' : params.sort_by == 'name' && params.order_by == 'asc', 'sorting_desc' : params.sort_by == 'name' && params.order_by == 'desc' }">Name</th>
                        <th @click="filterParam('sort', 'price')" :class="{ 'table-custom-header' : params.sort_by != 'price', 'sorting_asc' : params.sort_by == 'price' && params.order_by == 'asc', 'sorting_desc' : params.sort_by == 'price' && params.order_by == 'desc' }">Price</th>
                        <th @click="filterParam('sort', 'is_payment')" :class="{ 'table-custom-header' : params.sort_by != 'is_payment', 'sorting_asc' : params.sort_by == 'is_payment' && params.order_by == 'asc', 'sorting_desc' : params.sort_by == 'is_payment' && params.order_by == 'desc' }">Payment required</th>
                        <th @click="filterParam('sort', 'created_at')" :class="{ 'table-custom-header' : params.sort_by != 'created_at', 'sorting_asc' : params.sort_by == 'created_at' && params.order_by == 'asc', 'sorting_desc' : params.sort_by == 'created_at' && params.order_by == 'desc' }">Created On</th>
                        <th @click="filterParam('sort', 'doctor')" :class="{ 'table-custom-header' : params.sort_by != 'doctor', 'sorting_asc' : params.sort_by == 'doctor' && params.order_by == 'asc', 'sorting_desc' : params.sort_by == 'doctor' && params.order_by == 'desc' }">Created By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="service in services">
                        <td>@{{service.name}}</td>
                        <td>@{{service.price}}</td>
                        <td>
                            <button class="btn btn-success btn-sm" v-if="service.is_payment">Yes</button>
                            <button class="btn btn-danger btn-sm" v-else>No</button>
                        </td>
                        <td>@{{service.created_at ? moment(service.created_at).format('ddd Do, MMM, YYYY') : 'N/A'}}</td>
                        <td>@{{service.doctor_name}}</td>
                        <td>
                            <div class="row">
                                <div class="col-md-4">
                                    <a :href="base_url + '/services/' + service.id" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> View</a>
                                </div>
                                <div class="col-md-8">
                                    <form :action="base_url + '/services/' + service.id" method="POST">
                                        {{csrf_field()}}{{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <h4 v-else>There are no services</h4>

            <div class="row">
                <div class="col-md-6">
                    <p v-if="counts && counts > params.perPage && (params.pageNo * params.perPage < counts)">Showing @{{ (params.pageNo * params.perPage) - (params.perPage - 1) }} to @{{ params.pageNo * params.perPage }} of @{{ counts }} entries</p>
                    <p v-if="counts && counts > params.perPage && (((params.pageNo * params.perPage) - (params.perPage - 1)) < counts && params.pageNo * params.perPage > counts)">Showing @{{ (params.pageNo * params.perPage) - (params.perPage - 1) }} to @{{ counts }} of @{{ counts }} entries</p>
                    <p v-if="counts && counts < params.perPage">Showing @{{ (params.pageNo * params.perPage) - (params.perPage - 1) }} to @{{ counts }} of @{{ counts }} entries</p>
                    <p v-if="counts && counts === params.perPage">Showing @{{ (params.pageNo * params.perPage) - (params.perPage - 1) }} to @{{ counts }} of @{{ counts }} entries</p>
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        <span class="fa fa-angle-left custom-arrow" style="font-size: 25px" @click="filterParam('page', 'previous')"></span>
                        <span class="fa fa-angle-right custom-arrow" style="font-size: 25px" @click="filterParam('page', 'next')"></span>
                        <span class="count"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/vue.min.js') }}"></script>

    <script !src="">
        new Vue({
            el: '#services-wrapper',
            data: {
                auth: window.auth,
                base_url: window.location.origin,
                services: [],
                counts: 0,
                params: {
                    keyword: '',
                    pageNo: 1,
                    perPage: 10,
                    sort_by: '',
                    order_by: '',
                    _token: '{{ csrf_token() }}'
                },
                keywordTyping: ''
            },
            methods: {
                filterParam(key, val) {
                    _this = this;

                    if (key == 'page') {
                        if (val == 'next') {
                            if (_this.params.pageNo * _this.params.perPage > _this.counts) {
                                return false;
                            }

                            _this.params.pageNo += 1;
                        } else {
                            if (_this.params.pageNo == 1) {
                                return false;
                            }

                            _this.params.pageNo -= 1;
                        }
                    } else if (key == 'sort') {
                        if (_this.params.order_by == '') {
                            _this.params.order_by = 'asc';
                        } else {
                            if (_this.params.order_by == 'asc') {
                                _this.params.order_by = 'desc';
                            } else {
                                _this.params.order_by = 'asc';
                            }
                        }

                        _this.params.sort_by = val;
                    }

                    _this.getServices();
                },
                getServices() {
                    _this = this;

                    // Submit the form using AJAX.
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('services.all') }}',
                        data: _this.params,
                        success: function(response) {
                            _this.counts = response.data.counts;
                            _this.services = response.data.services;
                            $('#services-wrapper').fadeIn();
                        }
                    });
                },
                keyTyping: function(){
                    let THIS = this;
                    clearInterval(THIS.keywordTyping);
                    THIS.keywordTyping = setInterval(function () {
                        clearInterval(THIS.keywordTyping);
                        THIS.getServices();
                    }, 1000)
                },
            },
            mounted: function () {
                this.getServices();
            }
        })
    </script>
@stop
