<div class="page-content">
  <div class="container">
    <div class="row">
      <div class="col col-login mx-auto">
        <form class="card" action="/login" method="post">
          <div class="card-body p-6">
            <div class="card-title text-center">Login</div>
            {{ flash.output() }}
            <div class="form-group">
              <label class="form-label">Username</label>
              <input name="username" type="text" class="form-control" placeholder="Enter username">
            </div>
            <div class="form-group">
              <label class="form-label">Password <a href="/resetpassword" class="float-right small">Forgot password?</a></label>
              <input name="password" type="password" class="form-control" placeholder="Password">
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
