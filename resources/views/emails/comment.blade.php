<html>
<head></head>
<body style="background: wheat; color: black">
<h1>Repair Industry</h1>
<b>from:{{$from}}</b>
<p>{{$ticketComment}}</p>

<h1>reply To Ticket below</h1>
<form method='post' style="background: #4cc0c1" action="{{$replyUrl}}">
   <div style="margin-bottom:10px">
            <label for="textarea">reply</label><br>
            <textarea cols="60" rows="5" name="comment" placeholder="Reply to Ticket Here" id="textarea"></textarea>
        </div>

  <input type='submit' value='Submit' />
</form>
</body>
</html>
