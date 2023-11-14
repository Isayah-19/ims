<!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="Add" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add Student</h4>
                </div>
                <div class="modal-body">
                    <br>
                    <p>You are now adding student data</p><br>
                    <form action="add_student.php" method="POST" >
                    <div class="row">
                        <div class="col-md-4 form-group">
                            *Student Number <input name="stud_no" type="text" class="form-control" placeholder="ex. C027-01-000/2020" required/>
                        </div>
                        <div class="col-md-4 form-group">
                            *Email Address<input name="stud_email" type="text" class="form-control" placeholder="ex. email@students.dkut.ac.ke" required/>
                        </div>
                        <div class="col-md-4 form-group">
                            *Contact Number<input name="stud_mobileNo" type="text" class="form-control" placeholder="ex. 0700123456" required/>
                        </div>
                        <div class="col-md-4 form-group">
                            *Full Name <input name="stud_fullname" type="text" class="form-control" placeholder="Full Name" required/>
                        </div>
                        <div class="col-md-4 form-group">
                            *Course
                            <select name="stud_course" type="text" class="form-control m-bot15" required>
                                <option value="BSIT">BSIT</option>
                                <option value="BSENT">BSENT</option>
                                <option value="BSBA MM">BSBA MM</option>
                                <option value="BBTE">BBTE</option>
                                <option value="DICT"></option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            *Year<input name="stud_yrlevel" type="number" class="form-control" placeholder="Section" required/>
                        </div>
                        <div class="col-md-4 form-group">
                            *Gender<select name="stud_gender" type="text" class="form-control m-bot15">
                            <option value="Male">Male</option>    
                            <option value="Female">Female</option>    
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            *Birth Date<input name="stud_birth_date" type="Date" class="form-control" required/>
                        </div>
                        <div class="col-md-4 form-group">
                            *Student Status<select name="stud_status" class="form-control" required>
                                <option value="Regular">Regular Student</option>
                                <option value="Irregular">Irregular Student</option>
                                <option value="Disqualified">Disqualified Student</option>
                                <option value="LOA">Leave of Absence</option>
                                <option value="Transferee">Transferee Student</option>
                                </select>
                        </div>
                        <div class="col-md-12 form-group">
                            *Address<input name="stud_address" type="text" class="form-control" placeholder="enter your home/ permanent address">
                        </div>
                    </div>
                    <div class="modal-footer">
                        
                        <button><input type="submit">Submit</button>
                        <button data-dismiss="modal" class="btn btn-cancel" type="button">Cancel</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL-->