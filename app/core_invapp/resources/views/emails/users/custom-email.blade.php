<table style="width:100%;max-width:620px;margin:0 auto;background-color:#ffffff;">
    <tbody>
    <tr>
        <td style="text-align: center; padding-bottom:15px">
                <img class="logo-img" style="max-height: 40px; width: auto;" src="{{ get_mail_branding() }}" alt="{{ site_info('name') }}">
            </td>
            </tr>
            <tr>
        <td style="padding: 0 30px 20px">
            <p style="margin-bottom: 10px;"><strong>{{ $data['greeting'] }}</strong></p>
            <div style="margin-bottom: 10px;">{!! auto_p($data['message']) !!}</div>
        </td>
    </tr>
    <tr>
        <td style="text-align: center; padding:25px 20px 0;">
            <p style="font-size: 13px;">{!! __(get_email_copyright()) !!}</p>
            @if(!empty(social_links('all')) && count(social_links('all')) > 0) 
            <ul style="margin: 10px -4px 0;padding: 0;">
                @foreach(social_links('all') as $social => $item)
                    @if(isset($item['link']) && $item['link'])
                    <li style="display: inline-block; list-style: none; padding: 4px;">
                        <a style="display: inline-block;" href="{{ $item['link'] }}">
                            {{ ucfirst($social) }}
                            {{-- <img style="width: 28px" src="{{ asset('images/'.strtolower($social).'.png') }}" alt="{{ $item['title'] ?? '' }}"> --}}
                        </a>
                    </li>
                    @endif
                @endforeach
            </ul>
            @endif
        </td>
    </tr>
    </tbody>
</table>
