<table  align="center" cellspacing="0" cellpadding="0" border="0" style="width:100%; max-width:600px; border:0;">
    <tr>
        <td style="width: 100%;padding-top:20px;padding-bottom:20px;text-align:center;"><img style="max-width: 130px;" src="{{ asset('images/logotype.png') }}"></td>
    </tr>
    <tr>
        <td style="width: 100%;padding-top:0px;padding-bottom:20px;text-align:center;font-family: Arial, Helvetica, sans-serif;font-size:20px; line-height:20px; color:#222222;">Привет, {{ $firstName }} {{ $lastName }}</td>
    </tr>
    <tr>
        <td style="width: 100%;padding-top:15px;padding-bottom:15px;text-align:center;font-family: Arial, Helvetica, sans-serif;font-size:16px; line-height:16px; color:#222222;"> Данные в часах по дням за последнюю неделю</td>
    </tr>

    @foreach ($week as $day)
        <tr style="text-align:center;">
            <td>
                <span>{{ day_of_week($day->date) }} ({{ format_date('d.m', $day->date) }})</span>
                <span> - </span>
                <span>{{ $day->worktime }} ч</span>
            </td>
        </tr>
    @endforeach

    <tr>
        <td style="width: 100%;padding-top:15px;padding-bottom:15px;text-align:center;font-family: Arial, Helvetica, sans-serif;font-size:16px; line-height:16px; color:#222222;">Данные за последние недели месяца</td>
    </tr>


    @foreach ($weeks->getOriginal() as $key => $time)
        <tr style="text-align:center;">
            <td>
                <span>{{ $key  }}</span>
                <span> - </span>
                <span>{{ $time }}ч.</span>
            </td>
        </tr>
    @endforeach

    <tr>
        <td style="width: 100%;padding-top:15px;padding-bottom:15px;text-align:center;font-family: Arial, Helvetica, sans-serif;font-size:16px; line-height:16px; color:#222222;">Данные за последние три месяца</td>
    </tr>

    @foreach ($months->getOriginal() as $key => $time)
        <tr style="text-align:center;">
            <td>
                <span>{{ month_ru($key) }}</span>
                <span>{{ $time }} ч.</span>
            </td>
        </tr>
    @endforeach

    @foreach ($months->getOriginal() as $key => $time)
        <tr style="text-align:center;">
            <td>
                <span>{{ month_ru($key) }}</span>
                <span>{{ $time }} ч.</span>
            </td>
        </tr>
    @endforeach
</table>


@foreach ($teamleadUsers as $key => $user)
    <table  align="center" cellspacing="0" cellpadding="0" border="0" style="width:100%; max-width:600px; border:0;">
        <tr>
            <th style="width: 100%;padding-top:20px;padding-bottom:20px;text-align:center;"><img style="max-width: 130px;" src="{{ $user['first_name'] }}"></th>
        </tr>
        <tr>
            <th style="width: 100%;padding-top:0px;padding-bottom:20px;text-align:center;font-family: Arial, Helvetica, sans-serif;font-size:20px; line-height:20px; color:#222222;"> {{ $user['last_name'] }}</th>
        </tr>
    </table>
@endforeach
