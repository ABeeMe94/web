<div class="container">
    <div class="jumbotron text-center">
        <div class="col-lg-12 col-xl-12">
            <h1>
                PROVEEDORES
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus-circle"></i></button>
            </h1>
        </div>
    </div>
    <div class="row jumbotron">
        <form action="crear.php" name="formCrear" id="formCrear">
            <p align="center"><input type="image" name="crearContacto" id="crearContacto"></p>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus-circle"></i></button>
        </form>
        <form action="ver.php" name="formVer" id="formVer">
            <p align="center"><input type="image" name="verContacto" id="verContacto"></p>
        </form>
        <form action="modificar.php" name="formListar" id="formListar">
            <p align="center"><input type="image" name="modificarContacto" id="modificarContacto"></p>
        </form>
        <form action="listar.php" name="formListar" id="formListar">
            <p align="center"><input type="image" name="listarContacto" id="listarContacto"></p>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="guardarbd.php" method="post" name="formCrearContacto" id="formCrearContacto">
                        <table width="15%" align="center">
                            <tr>
                                <td></td>
                                <td><input type="text" name="nombre" id="nombre" autofocus/></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="text" name="telefono" id="telefono"/></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="text" name="descripcion" id="descripcion"/></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center"><input type="image" name="guardar" id="guardar"/></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <p align="center"><a href="listar.php"></a></p>
    <p align="center"><a href="modificar.php"/></p>
    <p align="center"><a href="index.php"></a></p>
</div>