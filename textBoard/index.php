<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=utf-8" />
        <title>留言板</title>
        <style type="text/css">
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                background-color: DarkSeaGreen;
            }
            .container {
                display: flex;
                height: 90vh;
                align-items: center;
                flex-direction: column;
            }
            .content {
                width: 60vw;
                height: 68%;
                margin-top: 10px;
                background-color: BlanchedAlmond;
                overflow: auto;
                padding: 1em;
            }
            .post {
                width: 60vw;
                height: 28%;
                margin-top: 10px;
                background-color: BlanchedAlmond;
                overflow: auto;
                padding: 1em;
            }
            form label,input {
                margin: 2px;
            }
            #content {
                height: 6em;
                width: 100%;
            }
        </style>
    </head>
    <body>
        <h1 style="text-align: center; line-height: 10vh;">匿名留言板</h1>
        <hr />
        <div class="container">
            <div class="content">
                <p style="font-size: 500pt;">test</p>
                <p style="font-size: 500pt;">test</p>
            </div>
            <div class="post">
                <form action="handler.php" method="post">
                    <label for="nick">昵称</label>
                    <input id="nick" type="text" name="nick" />
                    <br />
                    <label for="content">内容</label>
                    <br />
                    <textarea id="content" type="text" name="content"></textarea>
                    <br />
                    <input type="submit" value="发布"/>
                </form>
            </div>
        </div>
    </body>
</html>