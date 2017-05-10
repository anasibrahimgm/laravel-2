@extends('main')

@section('title', '| Edit Blog Post')

@section('stylesheets')
  {!! Html::style('css/select2.min.css') !!}

  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'link code',
    });
  </script>
  
@stop

@section('content')

  <div class="row">
    {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'PUT' ] ) !!}
    <div class="col-md-8">
      {{ Form::label('title', 'Title:')}}
      {{ Form::text('title', null, ['class' => 'form-control input-lg']) }}
      <br />

      {{ Form::label('slug', 'Slug:') }}
      {{ Form::text('slug', null, ['class' => 'form-control']) }}

      {{ Form::label('category_id', 'Category:') }}
      {{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}

      {{ Form::label('tags', 'Tags:', ['class' => 'form-spacing-top']) }}
      {{ Form::select('tags[]', $tags, null, ['class' => 'select2-multi  form-control', 'multiple' => 'multiple']) }}

      {{ Form::label('body', 'Body:')}}
      {{ Form::textarea('body', null, ['class' => 'form-control'] ) }}
    </div>

    <div class="col-md-4">
      <div class="well">
        <dl class="dl-horizontal">
          <dt>Created At:</dt>
          <dd>{{ date('M j, Y h:i a', strtotime($post->created_at)) }}</dd>
        </dl>

        <dl class="dl-horizontal">
          <dt>Last Updated:</dt>
          <dd>{{ date('M j, Y h:i a', strtotime($post->updated_at)) }}</dd>
        </dl>
        <hr />
        <div class="row">
          <div class="col-sm-6">
            {!! Html::linkRoute('posts.show', 'Cancel', array($post->id), array('class' => 'btn btn-danger btn-block') ) !!}
          </div>

          <div class="col-sm-6">
            {{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-block'])}}
          </div>
        </div>
      </div>
    </div>
    {!! Form::close() !!}
    <!--end of the .row (form)-->
  </div>
@stop

@section('scripts')
    {!! Html::script('js/select2.full.min.js') !!}

    <script type="text/javascript">
    $('.select2-multi').select2();
    </script>
@endsection
