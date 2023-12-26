<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laravel Generate QR Code Examples</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
   
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            
            
        @foreach( $bookingtransactiondtls as $bookingdtls )

        {{$bookingdtls->bookingno}}

        @endforeach	
        
            <div class="card-body">
                {!! QrCode::size(200)->generate('Jitendra',public_path('qrcodeimages/qrcode.svg')) !!}
            </div>

           <!--{{!! QrCode::size(200)->BTC('address', 0.0034, [
                'label' => 'my label',
                'message' => 'my message',
                'returnAddress' => 'https://www.returnaddress.com'
            ]); !!}!-->


        </div>
        <!--<div class="card">
            <div class="card-header">
                <h2>Color QR Code</h2>
            </div>
            <div class="card-body">
                {!! QrCode::size(300)->backgroundColor(255,90,0)->generate('RemoteStack') !!}
            </div>
        </div>!-->
    </div>
</body>
</html>
