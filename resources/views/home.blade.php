@extends('layouts.app')

@section('content')
    <div class="row row-cards row-deck">
        <div class="col-12">
            <div class="card mediaplayer">
                <div class="table-responsive">
                    <div id="nowplaying" class="col-sm-12">
                        <div id="nowplaying_bg">
                            <img id="nowplaying_bg_image" src="{{ asset('/images/album_temp_bg.jpg') }}" />
                            <div id="nowplaying_overlay"></div>
                        </div>
                        <div id="nowplaying_content" class="card card-aside">
                            <img id="nowplaying-album-image" class="card-aside-column" src="{{ asset('/images/album_temp_bg.jpg') }}" alt="album image" />
                            <div id="nowplaying-info" class="card-body d-flex flex-column mt-auto">
                                <h3 style="font-size:20px;margin-bottom:1px;">Ghosts &apos;n stuff</h3>
                                <p class="mb-2" style="font-size:18px;">Deadmau5</p>
                                <div class="d-flex align-items-center mt-auto">
                                    <a href="#" class="upvote"><i class="fa fa-thumbs-up"></i></a>
                                    <a href="#" class="downvote mx-3"><i class="fa fa-thumbs-down"></i></a>

                                    <div id="nowplaying_requestedby" class="pl-3">
                                        <small class="text-muted">Requested by</small>
                                        <div>Someone</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-outline table-vcenter text-nowrap card-table">
                        <thead>
                            <tr>
                                <td colspan="5" class="bg-light">
                                    <div class="small text-muted"><i class="fe fe-clock"></i> Coming up</div>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center w-1"></th>
                                <th>Song</th>
                                <th>Requested by</th>
                                <th>Duration</th>
                                <th>Est. Time played</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <span class="stamp mediasource file stamp-md bg-blue text-white mr-3">
                                        <i class="fa fa-music"></i>
                                    </span>
                                </td>
                                <td>
                                    <div>Never gonna give you up</div>
                                    <div class="small text-muted">
                                        Rick Astley
                                    </div>
                                </td>
                                <td>
                                    <div>John Lee</div>
                                </td>
                                <td>
                                    <div>3:33</div>
                                </td>
                                <td>
                                    <div>15:07</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <span class="stamp mediasource spotify stamp-md bg-green text-white mr-3">
                                        <i class="fa fa-spotify"></i>
                                    </span>
                                </td>
                                <td>
                                    <div>Livin la vida loca</div>
                                    <div class="small text-muted">
                                        Eddie Murphy, Antonio Banderas
                                    </div>
                                </td>
                                <td>
                                    <div>Bobby Knight</div>
                                </td>
                                <td>
                                    <div>3:24</div>
                                </td>
                                <td>
                                    <div>15:11</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                <span class="stamp mediasource youtube stamp-md bg-red text-white mr-3">
                                    <i class="fa fa-youtube-play"></i>
                                </span>
                                </td>
                                <td>
                                    <div>Sweet but Psycho</div>
                                    <div class="small text-muted">
                                        Ava Max
                                    </div>
                                </td>
                                <td>
                                    <div>John Lee</div>
                                </td>
                                <td>
                                    <div>3:07</div>
                                </td>
                                <td>
                                    <div>15:14</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                <span class="stamp mediasource soundcloud stamp-md bg-orange text-white mr-3">
                                    <i class="fa fa-soundcloud"></i>
                                </span>
                                </td>
                                <td>
                                    <div>Sweet but Psycho</div>
                                    <div class="small text-muted">
                                        Ava Max
                                    </div>
                                </td>
                                <td>
                                    <div>John Lee</div>
                                </td>
                                <td>
                                    <div>3:07</div>
                                </td>
                                <td>
                                    <div>15:14</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
