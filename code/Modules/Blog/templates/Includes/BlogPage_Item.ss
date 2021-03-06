<div class="container">
    <div class="row">
        <div class="page__content has-sidebar">
            <article class="blog__item blog__item--page">
                <% if $Image %>
                    <figure class="blog__item__image">
                        {$Image.setWidth(848).SrcSet(75, 100)}
                    </figure><!-- /.blog__item__image -->
                <% end_if %>
                <h1 class="page__content__heading">{$Title}</h1><!-- /.page__content__heading -->
                <% if $Content %>
                    <div class="blog__item__content typography">
                        {$Content}
                    </div><!-- /.blog__item__content typography -->
                <% end_if %>
                <% include Sharer %>
                <% include Comments %>
            </article><!-- /.blog__item -->
        </div><!-- /.page__content has-sidebar -->
        <% include BlogSidebar %>
    </div><!-- /.row -->
</div><!-- /.container -->
<% include PreviousNextPage %>