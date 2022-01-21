@php
    use Illuminate\Support\Facades\DB;
@endphp
@extends('layouts.app')

@section('title', 'Account-Setup')

@push('css')
<link href="{{ asset('assets/backend/layouts/css/plugins/jsTree/style.min.css')}}" rel="stylesheet">
   <style>
        .jstree-open > .jstree-anchor > .fa-folder:before {
            content: "\f07c";
        }
    
        .jstree-default .jstree-icon.none {
            width: 0;
        }
    </style>

@endpush

@section('breadcrumb')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Account Setup</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Home</a>
            </li>
            <li class="breadcrumb-item">
                Account Setup
            </li>
            <li class="breadcrumb-item active">
                <strong>All Account List</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">  
    <div class="row">

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Income Account </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
				
					<!-- Income Head Show Section Start -->

                    <div id="jstree1" style="color: #1ab394; text-transform:capitalize">
                        @php
                            $incomes_level_ones = DB::table('accounts')->where('acc_types', 1)->where('acc_level', 1)->get();   
                        @endphp
						@if($incomes_level_ones->count() > 0)
                        <ul>
                            @foreach($incomes_level_ones as $income_level_one)
                            <li class="jstree-open">{{ $income_level_one->name }} @if($income_level_one->current_balance > 0) ({{ number_format($income_level_one->current_balance, 2) }}/=) @endif

                                @php
                                    $incomes_level_twos = DB::table('accounts')->where('acc_types', 1)->where('acc_level', 2)->where('immediate_parent', $income_level_one->id )->get();   
                                @endphp
								@if($incomes_level_twos->count() > 0) 
                                <ul>
                                    @foreach($incomes_level_twos as $incomes_level_two)
                                    <li>{{ $incomes_level_two->name }} @if($incomes_level_two->current_balance > 0) ({{ number_format($incomes_level_two->current_balance, 2) }}/=) @endif

                                        @php
                                            $incomes_level_threes = DB::table('accounts')->where('acc_types', 1)->where('acc_level', 3)->where('immediate_parent', $incomes_level_two->id )->get();   
                                        @endphp
										@if($incomes_level_threes->count() > 0)
                                        <li class="jstree-open">{{ $incomes_level_two->name }}
                                            <ul>
                                                @foreach($incomes_level_threes as $incomes_level_three)
                                                    <li>{{ $incomes_level_three->name }} @if($incomes_level_three->current_balance > 0) ({{ number_format($incomes_level_three->current_balance, 2) }}/=) @endif
                                                        
                                                        @php
                                                            $incomes_level_fours = DB::table('accounts')->where('acc_types', 1)->where('acc_level', 4)->where('immediate_parent', $incomes_level_three->id )->get();   
                                                        @endphp
														@if($incomes_level_fours->count() > 0)
                                                        <li class="jstree-open">{{ $incomes_level_three->name }}
                                                            <ul>
                                                                @foreach($incomes_level_fours as $incomes_level_four)
                                                                    <li>{{ $incomes_level_four->name }}  @if($incomes_level_four->current_balance > 0) ({{ number_format($incomes_level_four->current_balance, 2) }}/=) @endif
                                                                        
                                                                        @php
                                                                            $incomes_level_fives = DB::table('accounts')->where('acc_types', 1)->where('acc_level', 5)->where('immediate_parent', $incomes_level_four->id )->get();   
                                                                        @endphp
																		@if($incomes_level_fives->count() > 0)
                                                                        <li class="jstree-open">{{ $incomes_level_four->name }}
                                                                            <ul>
                                                                                @foreach($incomes_level_fives as $incomes_level_five)
                                                                                    <li>{{ $incomes_level_five->name }} @if($incomes_level_five->current_balance > 0) ({{ number_format($incomes_level_five->current_balance, 2) }}/=) @endif
                                                                                        
                                                                                        @php
                                                                                            $incomes_level_sixes = DB::table('accounts')->where('acc_types', 1)->where('acc_level', 6)->where('immediate_parent', $incomes_level_five->id )->get();   
                                                                                        @endphp
																						@if($incomes_level_sixes->count() > 0)
                                                                                        <li class="jstree-open">{{ $incomes_level_five->name }}
                                                                                            <ul>
                                                                                                @foreach($incomes_level_sixes as $incomes_level_six)
                                                                                                    <li>{{ $incomes_level_six->name }} @if($incomes_level_six->current_balance > 0) ({{ number_format($incomes_level_six->current_balance, 2) }}/=) @endif

                                                                                                        @php
                                                                                                            $incomes_level_sevens = DB::table('accounts')->where('acc_types', 1)->where('acc_level', 7)->where('immediate_parent', $incomes_level_six->id )->get();   
                                                                                                        @endphp
																										@if($incomes_level_sevens->count() > 0)
                                                                                                        <li class="jstree-open">{{ $incomes_level_six->name }} 
                                                                                                            <ul>
                                                                                                                @foreach($incomes_level_sevens as $incomes_level_seven)
                                                                                                                    <li>{{ $incomes_level_seven->name }} @if($incomes_level_seven->current_balance > 0) ({{ number_format($incomes_level_seven->current_balance, 2) }}/=) @endif
                                                                                                                        
                                                                                                                    </li>
                                                                                                                @endforeach
                                                                                                                
                                                                                                            </ul>
                                                                                                        </li>
																										@endif
                                                                                                        
                                                                                                    </li>
                                                                                                @endforeach
                                                                                                
                                                                                            </ul>
                                                                                        </li>
																						@endif

                                                                                    </li>
                                                                                @endforeach
                                                                                
                                                                            </ul>
                                                                        </li>
																		@endif

                                                                    </li>
                                                                @endforeach
                                                                
                                                            </ul>
                                                        </li>
														@endif

                                                    </li>
                                                @endforeach
                                                
                                            </ul>
                                        </li>
										@endif
                                    </li>
                                    @endforeach                                    
                                </ul>
								@endif

                            </li>
                            @endforeach
                        </ul>
						@endif
                    </div>
					
					<!-- Income Head Section End -->
					
					

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Expense Account </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
				
                <!-- Expense Head Show Section Start -->

                <div id="jstree2" style="color: #dc3545; text-transform:capitalize">
                    @php
                        $expense_level_ones = DB::table('accounts')->where('acc_types', 2)->where('acc_level', 1)->get();   
                    @endphp
					@if($expense_level_ones->count() > 0)
                    <ul>
                        @foreach($expense_level_ones as $expense_level_one)
                        <li class="jstree-open">{{ $expense_level_one->name }}

                            @php
                                $expense_level_twos = DB::table('accounts')->where('acc_types', 2)->where('acc_level', 2)->where('immediate_parent', $expense_level_one->id )->get();   
                            @endphp
							@if($expense_level_twos->count() > 0)
                            <ul>								
                                @foreach($expense_level_twos as $expense_level_two)
                                <li>{{ $expense_level_two->name }}

                                    @php
                                        $expense_level_threes = DB::table('accounts')->where('acc_types', 2)->where('acc_level', 3)->where('immediate_parent', $expense_level_two->id )->get();   
                                    @endphp
									@if($expense_level_threes->count() > 0)
                                    <li class="jstree-open">{{ $expense_level_two->name }}
                                        <ul>
                                            @foreach($expense_level_threes as $expense_level_three)
                                                <li>{{ $expense_level_three->name }}
                                                    
                                                    @php
                                                        $expense_level_fours = DB::table('accounts')->where('acc_types', 2)->where('acc_level', 4)->where('immediate_parent', $expense_level_three->id )->get();   
                                                    @endphp
													@if($expense_level_fours->count() > 0)
                                                    <li class="jstree-open">{{ $expense_level_three->name }}
                                                        <ul>
                                                            @foreach($expense_level_fours as $expense_level_four) 
                                                                <li>{{ $expense_level_four->name }}
                                                                    
                                                                    @php
                                                                        $expense_level_fives = DB::table('accounts')->where('acc_types', 2)->where('acc_level', 5)->where('immediate_parent', $expense_level_four->id )->get();   
                                                                    @endphp
																	@if($expense_level_fives->count() > 0)
                                                                    <li class="jstree-open">{{ $expense_level_four->name }}
                                                                        <ul>
                                                                            @foreach($expense_level_fives as $expense_level_five)
                                                                                <li>{{ $expense_level_five->name}}
                                                                                    
                                                                                    @php
                                                                                        $expense_level_sixes = DB::table('accounts')->where('acc_types', 2)->where('acc_level', 6)->where('immediate_parent', $expense_level_five->id )->get();   
                                                                                    @endphp
																					@if($expense_level_sixes->count() > 0)
                                                                                    <li class="jstree-open">{{ $expense_level_five->name }}
                                                                                        <ul>
                                                                                            @foreach($expense_level_sixes as $expense_level_six)
                                                                                                <li>{{ $expense_level_six->name }}

                                                                                                    @php
                                                                                                        $expense_level_sevens = DB::table('accounts')->where('acc_types', 1)->where('acc_level', 7)->where('immediate_parent', $expense_level_six->id )->get();   
                                                                                                    @endphp
																									@if($expense_level_sevens->count() > 0)
                                                                                                    <li class="jstree-open">{{ $expense_level_six->name }}
                                                                                                        <ul>
                                                                                                            @foreach($expense_level_sevens as $expense_level_seven)
                                                                                                                <li>{{ $expense_level_seven->name }}
                                                                                                                    
                                                                                                                </li>
                                                                                                            @endforeach
                                                                                                            
                                                                                                        </ul>
                                                                                                    </li>
																									@endif
                                                                                                    
                                                                                                </li>
                                                                                            @endforeach
                                                                                            
                                                                                        </ul>
                                                                                    </li>
																					@endif

                                                                                </li>
                                                                            @endforeach
                                                                            
                                                                        </ul>
                                                                    </li>
																	@endif

                                                                </li>
                                                            @endforeach
                                                            
                                                        </ul>
                                                    </li>
													@endif

                                                </li>
                                            @endforeach
                                            
                                        </ul>
                                    </li>
									@endif
									
                                </li>
                                @endforeach                                    
                            </ul>
							@endif

                        </li>
                        @endforeach
                    </ul>
					@endif
                </div>

                <!-- Income Head Section End -->
					
					

                </div>
            </div>
        </div>

        
    </div>


</div>
@endsection

@push('js')
    <script src="{{ asset('assets/backend/layouts/js/plugins/jsTree/jstree.min.js')}}"></script>
    <script>
        $(document).ready(function(){
    
            $('#jstree1').jstree({
                'core' : {
                    'check_callback' : true
                },
                'plugins' : [ 'types', 'dnd' ],
                'types' : {
                    'default' : {
                        'icon' : 'fa fa-folder'
                    },
                    'html' : {
                        'icon' : 'fa fa-file-code-o'
                    },
                    'svg' : {
                        'icon' : 'fa fa-file-picture-o'
                    },
                    'css' : {
                        'icon' : 'fa fa-file-code-o'
                    },
                    'img' : {
                        'icon' : 'fa fa-file-image-o'
                    },
                    'js' : {
                        'icon' : 'fa fa-file-text-o'
                    }
    
                }
            });

            $('#jstree2').jstree({
                'core' : {
                    'check_callback' : true
                },
                'plugins' : [ 'types', 'dnd' ],
                'types' : {
                    'default' : {
                        'icon' : 'fa fa-folder'
                    },
                    'html' : {
                        'icon' : 'fa fa-file-code-o'
                    },
                    'svg' : {
                        'icon' : 'fa fa-file-picture-o'
                    },
                    'css' : {
                        'icon' : 'fa fa-file-code-o'
                    },
                    'img' : {
                        'icon' : 'fa fa-file-image-o'
                    },
                    'js' : {
                        'icon' : 'fa fa-file-text-o'
                    }
    
                }
            });
    
        });
    </script>
@endpush
