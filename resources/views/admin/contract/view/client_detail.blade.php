@extends('admin.layout.app')
@section('title','تفاصيل العقد')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <h4>تفاصيل العقد </h4>
        </div>


    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="title_left">
                    <h4>بيانات الطرف الأول </h4>
                </div>

                @if(count($contract_client_first_side)>0 && !empty($contract_client_first_side))
                    <div class="x_content">
                        <div class="dashboard-widget-content">
                            @php
                                $i=1;
                            @endphp
                            @if(isset($contract_client_first_side) && !empty($contract_client_first_side))
                                @foreach($contract_client_first_side as $s)
                                    <div class="col-md-6 hidden-small">
                                        <h4 class="line_30">الطرف الأول ( {{ $i }} )</h4>


                                        <table class="countries_list">
                                            <tbody>

                                            <tr>
                                                <td>{{ $i.' ) '.$s->client->first_name.' '.$s->client->last_name }}</td>

                                            </tr>
                                            <tr>
                                                <td>رقم التواصل :- {{ $s->client->mobile}}</td>

                                            </tr>
                                            <tr>
                                                <td> العنوان :-{{ $s->client->address}}</td>

                                            </tr>
                                            {{--                                            @if($client->client_type=="multiple")--}}
                                            {{--                                                <tr>--}}
                                            {{--                                                    <td>Advocate:-{{ $s->party_advocate}}</td>--}}

                                            {{--                                                </tr>--}}

                                            {{--                                            @endif--}}


                                            </tbody>
                                        </table>
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach

                            @endif




                            {{--                        <div class="col-md-6 hidden-small">--}}

                            {{--                            <table class="countries_list">--}}
                            {{--                                <tbody>--}}

                            {{--                                <tr>--}}
                            {{--                                    <td>Email</td>--}}
                            {{--                                    <td class="fs15 fw700 text-right s">{{ $client->email ?? '' }}</td>--}}
                            {{--                                </tr>--}}
                            {{--                                <tr>--}}
                            {{--                                    <td>Alternate No.</td>--}}
                            {{--                                    <td class="fs15 fw700 text-right">{{ $client->alternate_no ?? '' }} </td>--}}
                            {{--                                </tr>--}}
                            {{--                                <tr>--}}
                            {{--                                    <td>Reference Mobile</td>--}}
                            {{--                                    <td class="fs15 fw700 text-right">{{ $client->reference_mobile ?? '' }}</td>--}}
                            {{--                                </tr>--}}
                            {{--                                <tr>--}}
                            {{--                                    <td>Address :</td>--}}
                            {{--                                    <td class="fs15 fw700 text-right">{{ $client->address ?? '' }}</td>--}}

                            {{--                                </tr>--}}


                            {{--                                </tbody>--}}
                            {{--                            </table>--}}
                            {{--                        </div>--}}


                        </div>
                    </div>

                @endif
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="title_left">
                    <h4>بيانات الطرف الثاني </h4>
                </div>
                @php
                    $ss=1;
                @endphp
                @if(isset($contract_client_second_side) && !empty($contract_client_second_side))
                    @foreach($contract_client_second_side as $s)
                        <div class="col-md-6 hidden-small">
                            <h4 class="line_30">الطرف الثاني ( {{ $ss }} )</h4>


                            <table class="countries_list">
                                <tbody>

                                <tr>
                                    <td>{{ $i.' ) '.$s->client->first_name.' '.$s->client->last_name }}</td>

                                </tr>
                                <tr>
                                    <td>رقم التواصل :- {{ $s->client->mobile}}</td>

                                </tr>
                                <tr>
                                    <td>العنوان :-{{ $s->client->address}}</td>

                                </tr>
                                {{--                                            @if($client->client_type=="multiple")--}}
                                {{--                                                <tr>--}}
                                {{--                                                    <td>Advocate:-{{ $s->party_advocate}}</td>--}}

                                {{--                                                </tr>--}}

                                {{--                                            @endif--}}


                                </tbody>
                            </table>
                        </div>
                        @php
                            $ss++;
                        @endphp
                    @endforeach

                @endif
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="title_left">
                    <h4>بنود العقد </h4>
                </div>
                @php
                    $sss=1;
                @endphp
                @if(isset($item) && count($contract_client_terms))

                    @foreach($contract_client_terms as $row_category)
                        <div class="col-md-6 hidden-small">
                            <h4 class="line_30">التصنيف ( {{ @$row_category->category->name }} )</h4>

                            @php $counter_term = 1 @endphp
                            <table class="countries_list">
                                <thead>
                                <tr>
                                    <th>( * ) البنود</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($row_category->get_terms()))
                                    @foreach($row_category->get_terms() as $row_term)
                                <tr>
                                    <td>{{ $counter_term.' ) '.@$row_term->term->name }}</td>

                                </tr>
                                @php $counter_term++ @endphp
                                    @endforeach
                                    @endif

                                {{--                                            @if($client->client_type=="multiple")--}}
                                {{--                                                <tr>--}}
                                {{--                                                    <td>Advocate:-{{ $s->party_advocate}}</td>--}}

                                {{--                                                </tr>--}}

                                {{--                                            @endif--}}


                                </tbody>
                            </table>
                        </div>
                        @php
                            $ss++;
                        @endphp
                    @endforeach

                @endif
            </div>
        </div>

    </div>


@endsection
