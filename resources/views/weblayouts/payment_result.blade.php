
<html class="no-js" dir="rtl" lang="fa-IR">
<head>
<head>
<link rel="stylesheet" href="/css/style.css">
</head>
</head>
<body>
<div class="result_call_back_payment_parent">
    <div class="content">
        <div class="inner">
            <div class="result">
            @if ($result == "success")
            <span class="success">پرداخت با موفقیت انجام شد.</span>
            @else
            <span class="error">متأسفانه پرداخت شما ناموفق بود!</span>
            @endif 
            </div>
            @if ($result=="success")
            <div class="amount">
                <span class="title">{{$result=="success" ? "مبلغ پرداخت شده" : "مبلغ قابل پرداخت"}}</span>
                <span class="price">{{number_format($onlinePayment->amount)}}</span>
                <span class="toman">تومان</span>
            </div>
            @endif

            @if ($result=="error")
            <div class="back_amount">
            <span>چنانچه مبلغی از حساب شما کسر شده است، تا 24 ساعت آینده به حساب شما باز خواهد گشت.</span>
            </div>
            @endif

            <div class="date_parent">
                <span class="title">تاریخ</span>
                <span class="date">{{$date}}</span>
            </div>
            <div class="dargah_parent">
                <span class="title">درگاه</span>
                <span class="dargah">زرین پال</span>
            </div>

            <div class="payment_btn" id="payment_btn" order_id={{$onlinePayment->order_id}}>
                {{-- helper backtosite() in file helper.php --}}
                <a href={{backToSite()}} class="back_to_site">بازگشت به سایت</a> 
            </div>

        </div>
    </div>
</div>
</body>
</html>