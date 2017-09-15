    </div>
</div>
</div>

</form>

<?php
// Para depurar
if($V_DEPURAR){
    debug($_SESSION);
}

?>

<footer class="footer">
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span2">
                <center><img src="css/images/logo.gif" title="logo" alt="logo" style="height: 50px;" ></center>
            </div>
            <div class="span5">
                <p style="vertical-align: bottom;">
                    Designed and built with all the love in the world by <a href="#">Tracy Padilla</a> and <a href="#">Luis Lizama</a>.
                </p>
            </div>
            <div class="span4 pagination-right">
                    <p style="vertical-align: bottom;">
                    <span xmlns:dct="http://purl.org/dc/terms/" property="dct:title"><?php echo $V_TITULO; ?></span> está distribuido bajo una <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Licencia Creative Commons Atribución-CompartirIgual 4.0 Internacional</a>.
                    </p>
            </div>
            <div class="span1">
                <center><a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">
                    <img alt="Licencia Creative Commons" style="border-width:0;" src="http://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a></center>
            </div>
        </div>
    </div>
</footer>

<style>
.footer {
    text-align: left;
    padding: 20px 0;/*
    margin-top: 70px;*/
    border-top: 1px solid #e5e5e5;
    border: 1px solid #d4d4d4;
    color: #555555;
    text-decoration: none;
    height: 50px;
    background-color: #e5e5e5;
    -webkit-box-shadow: inset 0 3px 8px rgba(0, 0, 0, 0.125);
    -moz-box-shadow: inset 0 3px 8px rgba(0, 0, 0, 0.125);
    box-shadow: inset 0 3px 8px rgba(0, 0, 0, 0.125);
}
</style>
</body>  
</html> 