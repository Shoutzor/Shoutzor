<div class="page-content">
  <div class="container">
    <div class="row">
      <div class="col col-login mx-auto">
        <form class="card" action="" method="post">
          <div class="card-body p-6">
            <div class="card-title text-center">Create account</div>
            {{ flash.output() }}
            <div class="form-group">
              <label class="form-label">Email</label>
              <input type="text" class="form-control" placeholder="Enter email">
            </div>
            <div class="form-group">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" placeholder="Enter username">
            </div>
            <div class="form-group">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
              <label class="form-label">Password (Repeat)</label>
              <input type="password-repeat" class="form-control" placeholder="">
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
          </div>
        </form>
        <div class="text-center text-muted">
          Already have an account? <a href="/login">Login</a>
        </div>
      </div>
    </div>
  </div>
</div>
