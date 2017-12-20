<aside class="col-sm-3 ml-sm-auto blog-sidebar">
  <div class="sidebar-module sidebar-module-inset">
    <h4>About</h4>
    <p>This is a blog built with the Laravel PHP framework and Twitter Bootstrap.</p>
  </div>
@if(count($archives))
  <div class="sidebar-module">
    <h4>Archives</h4>
    <ol class="list-unstyled">
      @foreach($archives as $archive)
        <li><a href="/?month={{ $archive['month'] }}&year={{ $archive['year'] }}">
          {{ $archive['month'] }} {{ $archive['year'] }}
        </a></li>
      @endforeach
      
    </ol>
  </div>
  @endif

@if(count($tags))
  <div class="sidebar-module">
    <h4>Tags</h4>
    <ol class="list-unstyled">
      @foreach($tags as $tag)
        <li><a href="/posts/tags/{{ $tag }}">
          <span class="badge badge-pill badge-primary">{{ $tag }}</span>
        </a></li>
      @endforeach
      
    </ol>
  </div>
@endif

  <div class="sidebar-module">
    <h4>Elsewhere</h4>
    <ol class="list-unstyled">
      <li><a href="#">GitHub</a></li>
      <li><a href="#">Twitter</a></li>
      <li><a href="#">Facebook</a></li>
    </ol>
  </div>
</aside><!-- /.blog-sidebar -->