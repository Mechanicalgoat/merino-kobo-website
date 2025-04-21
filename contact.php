<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メリノ工房 - お問い合わせ</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .contact-header {
            padding-top: 120px;
            text-align: center;
            margin-bottom: 40px;
        }
        
        .contact-header h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        
        .contact-form {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin-bottom: 80px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            font-family: inherit;
        }
        
        .form-group textarea {
            height: 150px;
            resize: vertical;
        }
        
        .human-check {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .human-check label {
            margin-right: 15px;
            font-weight: 600;
        }
        
        .human-check span {
            font-size: 1.1rem;
            margin-right: 10px;
        }
        
        .human-check input {
            width: 80px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .submit-btn {
            background: linear-gradient(to right, #ADD3FF, #FFCAA9);
            color: #333;
            border: none;
            padding: 12px 30px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 0.9rem;
            margin-top: 5px;
            display: none;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
            display: none;
        }
        
        @media (max-width: 768px) {
            .contact-form {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1>メリノ工房</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="privacy-policy.html">プライバシーポリシー</a></li>
                    <li><a href="contact.php" class="active">お問い合わせ</a></li>
                    <li><a href="works.html">作品一覧</a></li>
                    <li><a href="index.html">HOME</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="contact-header" id="contact">
        <div class="container">
            <h2>お問い合わせ</h2>
            <p>ご質問・ご相談はこちらからお気軽にどうぞ</p>
        </div>
    </section>

    <section class="contact">
        <div class="container">
            <?php
            if (isset($_POST['submit'])) {
                // ボット対策のチェック
                $honeypot = $_POST['honeypot'];
                $submit_time = $_POST['submit_time'];
                $time_elapsed = time() - intval($submit_time);
                $captcha_answer = $_POST['captcha-answer'];
                $captcha_expected = $_POST['captcha-expected'];
                
                if ($honeypot !== '' || $time_elapsed < 3) {
                    // ボット検出、ただし成功メッセージを表示（ボットに気づかれないため）
                    echo '<div class="success-message" style="display: block;">メッセージを送信しました。ありがとうございます。</div>';
                } else if ($captcha_answer !== $captcha_expected) {
                    // キャプチャ不一致
                    echo '<div class="error-message" style="display: block; margin-bottom: 20px;">キャプチャの回答が正しくありません。もう一度お試しください。</div>';
                } else {
                    // 入力内容の取得とサニタイズ
                    $name = htmlspecialchars($_POST['name']);
                    $email = htmlspecialchars($_POST['email']);
                    $subject = htmlspecialchars($_POST['subject']);
                    $inquiry_type = htmlspecialchars($_POST['inquiry-type']);
                    $message = htmlspecialchars($_POST['message']);
                    
                    // メールヘッダー
                    $to = "tomato.co.jp.blog@gmail.com";
                    $email_subject = "[メリノ工房] " . $subject;
                    $email_body = "名前: " . $name . "\n";
                    $email_body .= "メールアドレス: " . $email . "\n";
                    $email_body .= "問い合わせ種類: " . $inquiry_type . "\n\n";
                    $email_body .= "メッセージ内容:\n" . $message . "\n";
                    
                    $headers = "From: " . $email . "\r\n";
                    $headers .= "Reply-To: " . $email . "\r\n";
                    
                    // メール送信
                    if (mail($to, $email_subject, $email_body, $headers)) {
                        echo '<div class="success-message" style="display: block;">メッセージを送信しました。ありがとうございます。</div>';
                    } else {
                        echo '<div class="error-message" style="display: block; margin-bottom: 20px;">メッセージの送信に失敗しました。後ほど再度お試しいただくか、直接メールでお問い合わせください。</div>';
                    }
                }
            }
            ?>
            
            <form class="contact-form" id="contact-form" method="POST" action="">
                <div class="form-group">
                    <label for="name">お名前 <span style="color: #e74c3c;">*</span></label>
                    <input type="text" id="name" name="name" required>
                    <div class="error-message" id="name-error">お名前を入力してください</div>
                </div>
                
                <div class="form-group">
                    <label for="email">メールアドレス <span style="color: #e74c3c;">*</span></label>
                    <input type="email" id="email" name="email" required>
                    <div class="error-message" id="email-error">有効なメールアドレスを入力してください</div>
                </div>
                
                <div class="form-group">
                    <label for="subject">件名 <span style="color: #e74c3c;">*</span></label>
                    <input type="text" id="subject" name="subject" required>
                    <div class="error-message" id="subject-error">件名を入力してください</div>
                </div>
                
                <div class="form-group">
                    <label for="inquiry-type">お問い合わせ種類</label>
                    <select id="inquiry-type" name="inquiry-type">
                        <option value="general">一般的なお問い合わせ</option>
                        <option value="service">サービスについて</option>
                        <option value="collaboration">コラボレーションのご提案</option>
                        <option value="other">その他</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="message">メッセージ内容 <span style="color: #e74c3c;">*</span></label>
                    <textarea id="message" name="message" required></textarea>
                    <div class="error-message" id="message-error">メッセージを入力してください</div>
                </div>
                
                <div class="human-check">
                    <label>人間確認:</label>
                    <span id="captcha-question">
                        <?php 
                        $num1 = rand(0, 9);
                        $num2 = rand(0, 9);
                        $result = $num1 + $num2;
                        echo $num1 . " + " . $num2 . " = ?";
                        ?>
                    </span>
                    <input type="text" id="captcha-answer" name="captcha-answer" required>
                    <div class="error-message" id="captcha-error">正しい答えを入力してください</div>
                    <input type="hidden" id="captcha-expected" name="captcha-expected" value="<?php echo $result; ?>">
                    <input type="hidden" id="honeypot" name="honeypot">
                    <input type="hidden" id="submit-time" name="submit-time" value="<?php echo time(); ?>">
                </div>
                
                <button type="submit" name="submit" class="submit-btn">送信する</button>
            </form>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2025 メリノ工房. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // DOM elements
        const form = document.getElementById('contact-form');
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const subjectInput = document.getElementById('subject');
        const messageInput = document.getElementById('message');
        const captchaInput = document.getElementById('captcha-answer');
        
        // Validate form
        function validateForm() {
            let isValid = true;
            
            // Name validation
            if (nameInput.value.trim() === '') {
                document.getElementById('name-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('name-error').style.display = 'none';
            }
            
            // Email validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailInput.value.trim())) {
                document.getElementById('email-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('email-error').style.display = 'none';
            }
            
            // Subject validation
            if (subjectInput.value.trim() === '') {
                document.getElementById('subject-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('subject-error').style.display = 'none';
            }
            
            // Message validation
            if (messageInput.value.trim() === '') {
                document.getElementById('message-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('message-error').style.display = 'none';
            }
            
            return isValid;
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile navigation toggle (from scripts.js)
            const mobileToggle = document.createElement('div');
            mobileToggle.className = 'mobile-toggle';
            mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
            document.querySelector('header .container').appendChild(mobileToggle);
            
            const navList = document.querySelector('nav ul');
            
            mobileToggle.addEventListener('click', function() {
                navList.classList.toggle('active');
                this.innerHTML = navList.classList.contains('active') ? 
                    '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
            });
            
            // Form validation before submission
            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
