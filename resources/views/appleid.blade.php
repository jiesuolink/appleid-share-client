<!doctype html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @if(!$error)
    <meta http-equiv="refresh" content="180" />
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Apple ID 分享 | 演示站点</title>
</head>

<body>
    <div class="row justify-content-center">
        <div class="col-md-12 col-xxl-1">
            <div style="width: 23rem;">
                <div class="shadow p-3 mb-5 bg-white rounded">

                    @if($error)
                        <!-- 错误提示 -->
                        <h4>获取失败 <span class="badge badge-danger">错误</span></h4>
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @else
                        <!-- 正常显示 -->
                        @if ($appleId['status'] == 1)
                            @if ($appleId['time_now'] - strtotime($appleId['last_check']) > $appleId['interval'] * 120)
                            <h4>{{ $appleId['country'] }}共享账号 <span class="badge badge-info">检测中</span></h4>
                            @else
                            <h4>{{ $appleId['country'] }}共享账号 <span class="badge badge-primary">正常</span></h4>
                            @endif
                        @else
                        <h4>{{ $appleId['country'] }}共享账号 <span class="badge badge-danger">异常</span></h4>
                        @endif
                        <p>上次检测时间：{{ $appleId['last_check'] }}</p>

                        <!-- 邮箱 -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">邮箱</span>
                            </div>
                            <input type="text" class="form-control" id="email" value="{{ $appleId['email'] }}" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary copy" type="button" data-clipboard-text="{{ $appleId['email'] }}">复制</button>
                            </div>
                        </div>

                        <!-- 密码 -->
                        @if ($appleId['expired_at'] > $appleId['time_now'])
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">密码</span>
                            </div>
                            <input type="password" class="form-control" id="pass" value="{{ $appleId['password'] }}"  readonly>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" id="passBtn" type="button">显示</button>
                                <button class="btn btn-outline-secondary copy" type="button" data-clipboard-text="{{ $appleId['password'] }}">复制</button>
                            </div>
                        </div>

                        <!-- 提示信息 -->
                        @if ($appleId['status'] == 1)
                            @if(isset($appleId['show_tips']) && $appleId['show_tips'] == 1)
                            <div class="alert alert-danger" role="alert">
                                此为共享账号，请勿使用账号登录 iCloud。如果遇到账号无法使用请等待{{ $appleId['interval'] }}分钟后重试
                            </div>
                            @endif

                            <!-- 临时二维码 -->
                            @if(isset($appleId['temp_uri']) && $appleId['temp_uri'] && isset($appleId['show_tempuri']) && $appleId['show_tempuri'] == 1)
                            <div class="col-md-auto">
                                <p>手机扫描二维码获取账号(临时链接)</p>
                                <div id="qrcode"></div>
                            </div>
                            @endif
                        @else
                        <div class="alert alert-danger" role="alert">
                            账号状态异常可能正常无法使用，请联系管理员
                        </div>
                        @endif
                        @else
                        <!-- 过期提示 -->
                        <div class="alert alert-danger" role="alert">
                            此 Apple ID 托管已过期！
                        </div>
                        @endif

                        <!-- 备注信息 -->
                        @if(isset($appleId['remark']) && !empty($appleId['remark']))
                        <div class="alert alert-info" role="alert">
                            <strong>备注：</strong>{{ $appleId['remark'] }}
                        </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>

    @if(!$error)
    <!-- Clipboard.js -->
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>
    <script>
        var clipboard = new ClipboardJS('.copy');
        clipboard.on('success', function(e) {
            e.trigger.textContent = '复制成功';
            setTimeout(() => {
                e.trigger.textContent = '复制';
            }, 2000);
            e.clearSelection();
        });

        // 显示/隐藏密码
        var passInput = document.getElementById('pass');
        var passBtn = document.getElementById('passBtn');
        if (passBtn) {
            passBtn.addEventListener('click', function() {
                if(passInput.type === 'password') {
                    passBtn.innerHTML = '隐藏';
                    passInput.setAttribute('type', 'text');
                } else {
                    passBtn.innerHTML = '显示';
                    passInput.setAttribute('type', 'password');
                }
            });
        }
    </script>

    <!-- 二维码 -->
    @if(isset($appleId['temp_uri']) && $appleId['temp_uri'] && isset($appleId['show_tempuri']) && $appleId['show_tempuri'] == 1)
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script type="text/javascript">
        new QRCode("qrcode", {
            text: "{{ $appleId['temp_uri'] }}",
            width: 128,
            height: 128,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    </script>
    @endif
    @endif

</body>

</html>
