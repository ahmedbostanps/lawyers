<!DOCTYPE html>
<html>
<head>
    <style>
        .container {
            margin: auto;
            width: 95%;
        }

        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            text-align: center;
        }

        .remove-border {
            border: none !important;
            border-left: none !important;
            border-top: none !important;
            border-right: none !important;
            border-bottom: none !important;

        }

        .heading1 {
            font-size: 20px;
            font-style: bold;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
        }

        .heading2 {
            font-size: 17px;
            font-style: bold;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
        }

        .heading3 {
            font-size: 12px;
            font-style: bold;

        }
    </style>
    <title>تفاصيل العقد</title>
</head>
<body>
<div class="container">

    <h1 class="heading1" style="text-align: center;"><b>تفاصيل العقد</b></h1>
    <hr>


    @if(count($contract_client_first_side)>0 && !empty($contract_client_first_side))
        <table width="100%" border="0" style="border-style:none">
            <tr>
                <td colspan="2">
                    <h3>بيانات الطرف الأول</h3>
                </td>
            </tr>
            @foreach($contract_client_first_side as $s)

                <tr>
                    <td><h4 class="line_30">الطرف الأول ( {{ $loop->index + 1 }} )</h4></td>
                </tr>

                <tr>
                    <td>{{ $loop->index.' ) '.$s->client->first_name.' '.$s->client->last_name }}</td>

                </tr>
                <tr>
                    <td>رقم التواصل :- {{ $s->client->mobile}}</td>

                </tr>
                <tr>
                    <td> العنوان :-{{ $s->client->address}}</td>

                </tr>

            @endforeach
        </table>
    @endif
    <br/>


    @if(count($contract_client_second_side)>0 && !empty($contract_client_second_side))
        <table width="100%" border="0" style="border-style:none">
            <tr>
                <td colspan="2">
                    <h3>بيانات الطرف الثاني</h3>
                </td>
            </tr>
            @foreach($contract_client_second_side as $s)

                <tr>
                    <td><h4 class="line_30">الطرف الثاني ( {{ $loop->index + 1 }} )</h4></td>
                </tr>

                <tr>
                    <td>{{ $loop->index.' ) '.$s->client->first_name.' '.$s->client->last_name }}</td>

                </tr>
                <tr>
                    <td>رقم التواصل :- {{ $s->client->mobile}}</td>

                </tr>
                <tr>
                    <td> العنوان :-{{ $s->client->address}}</td>

                </tr>

            @endforeach
        </table>
    @endif
    <br/>

    @if(isset($item) && count($contract_client_terms))
        <table width="100%" border="0" style="border-style:none">
            <tr>
                <td colspan="2">
                    <h3>بنود العقد</h3>
                </td>
            </tr>
            @foreach($contract_client_terms as $row_category)

                <tr>
                    <td><h4 class="line_30">التصنيف ( {{ @$row_category->category->name }} )</h4></td>
                </tr>
                @if(count($row_category->get_terms()))
                    @foreach($row_category->get_terms() as $row_term)
                        <tr>
                            <td>{{ ($loop->index + 1).' ) '.@$row_term->term->name }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </table>
    @endif
    <br/>


    <br/>
    {{--    @if($totalCaseCount>0)--}}
    {{--        @if(count($case_dashbord) && !empty($case_dashbord))--}}
    {{--            @foreach($case_dashbord as $court)--}}
    {{--                <br/>--}}
    {{--                <table width="100%" border="0" style="border-style:none">--}}
    {{--                    <tr>--}}
    {{--                        <td class="remove-border heading2" width="50%"--}}
    {{--                            style="text-align: left;">{!! $court['judge_name'] !!}</td>--}}
    {{--                        <td class="remove-border heading2" width="50%" style="text-align: right;">Cases--}}
    {{--                            : {!! $court['caseCourt'] !!}</td>--}}
    {{--                    </tr>--}}
    {{--                </table>--}}
    {{--                <table width="100%" style="margin-top:12px; border-style: solid;">--}}
    {{--                    <tr>--}}
    {{--                        <td class="heading3" width="5%" style="text-align:center !important;"><b>Sr No </b></td>--}}
    {{--                        <td class="heading3" width="20%" style="text-align:center !important;"><b>Cases </b></td>--}}
    {{--                        <td class="heading3" width="40%" style="text-align:center !important;"><b> Petitioner vs--}}
    {{--                                Respondent </b></td>--}}
    {{--                        <td class="heading3" width="25%" style="text-align: center;"><b>Stage of Case</b></td>--}}
    {{--                        <td class="heading3" width="10%" style="text-align: center;"><b>Next Date</b></td>--}}
    {{--                    </tr>--}}

    {{--                    @if(!empty($court['cases']) && count($court['cases'])>0)--}}
    {{--                        @foreach($court['cases'] as $key=>$value)--}}
    {{--                            @php--}}
    {{--                                $class = ( $value->priority=='High')?'<b>**</b>':(( $value->priority=='Medium')?'<b>*</b>':'');--}}
    {{--                            @endphp--}}
    {{--                            @if($value->client_position=='Petitioner')--}}
    {{--                                @php--}}
    {{--                                    $first = $value->first_name.' '.$value->last_name;--}}
    {{--                                    $second = $value->party_name;--}}
    {{--                                @endphp--}}
    {{--                            @else--}}
    {{--                                @php--}}
    {{--                                    $first = $value->party_name;--}}
    {{--                                    $second = $value->first_name.' '.$value->last_name;--}}
    {{--                                @endphp--}}
    {{--                            @endif--}}

    {{--                            <tr>--}}
    {{--                                <td class="heading3 " width="2%"--}}
    {{--                                    style="text-align:center !important;">{!!$class!!}{{$key+1}}</td>--}}
    {{--                                <td class="heading3 " width="20%" style="text-align:left !important;">&nbsp;<span--}}
    {{--                                        class="text-primary">{{ $value->registration_number }}</span><br/><small>&nbsp;{{ ($value->caseSubType!='')?$value->caseSubType.'-'.$value->caseType:$value->caseType }}</small>--}}
    {{--                                </td>--}}
    {{--                                <td class="heading3 " width="35%" style="text-align:left !important;">--}}
    {{--                                    &nbsp;{!! $first !!} <br/><b>&nbsp;VS</b><br/> {!! $second !!}</td>--}}
    {{--                                <td class="heading3" width="28%" style="text-align: left;">--}}
    {{--                                    &nbsp;{{ $value->case_status_name }}</td>--}}
    {{--                                <td class="heading3" width="15%" style="text-align: left;">--}}
    {{--                                    &nbsp; @if($value->hearing_date!='')--}}
    {{--                                        {{date(LogActivity::commonDateFromatType(),strtotime($value->hearing_date))}}--}}
    {{--                                    @else--}}

    {{--                                    @endif</td>--}}
    {{--                            </tr>--}}

    {{--                        @endforeach--}}

    {{--                    @endif--}}
    {{--                </table>--}}
    {{--            @endforeach--}}
    {{--        @endif--}}
    {{--        <br/><br/>--}}
    {{--        <table width="100%" border="0" style="border-style:none">--}}
    {{--            <tr>--}}
    {{--                <td class="remove-border heading3" width="50%" style="text-align: left;">** Represents important--}}
    {{--                    cases.<br/>* Represents medium cases.--}}
    {{--                </td>--}}
    {{--            </tr>--}}
    {{--        </table>--}}
    {{--    @endif--}}
</div>
</body>
</html>
