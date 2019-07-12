<div class="page-content">
  <div class="container">
    <div class="row">
      <div class="col col-login mx-auto">
        <form class="card" action="" method="post">
          <div class="card-body p-6">
            <div class="card-title text-center">Login</div>
            {{ flash.output() }}
            <div class="form-group">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" placeholder="Enter email" data-kwimpalastatus="alive" data-kwimpalaid="1562757309465-5">
            </div>
            <div class="form-group">
              <label class="form-label">Password <a href="/resetpassword" class="float-right small">Forgot password?</a></label>
              <input type="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
          </div>
        </form>
        <div class="text-center text-muted">
          No account yet? <a href="/register">Register</a>
        </div>
      </div>
    </div>
  </div>
</div>
