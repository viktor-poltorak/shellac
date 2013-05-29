<div class="feedback">
    <h2>{t text="Feedback"}</h2>
    <img alt="" src="/images/feedback-top.png" />
    <div class="feedback-content">
        <form method="POST" action="/feedback">
            <p>
                Name:
                <input type="text" name="name" />
                E-mail:
                <input type="text" name="email" />
                Message:
                <textarea name="message"></textarea>
                <input type="submit" value="Send"/>
            </p>
        </form>
    </div>
    <img alt="" src="/images/feedback-bottom.png" />
</div>