@extends('layouts.app')

@section('content')
    <div class="row row-cards row-deck">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                        <thead>
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
                            <td colspan="5" class="bg-light">
                                <div class="small text-muted"><i class="fe fe-radio"></i> Now playing</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="stamp stamp-md bg-green text-white mr-3">
                                    <i class="fa fa-spotify"></i>
                                </span>
                            </td>
                            <td>
                                <div>Natural</div>
                                <div class="small text-muted">
                                    Imagine Dragons
                                </div>
                            </td>
                            <td>
                                <div>John Lee</div>
                            </td>
                            <td>
                                <div>3:09</div>
                            </td>
                            <td>
                                <div>15:04</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="bg-light">
                                <div class="small text-muted"><i class="fe fe-clock"></i> Coming up</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="stamp stamp-md bg-blue text-white mr-3">
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
                                <span class="stamp stamp-md bg-green text-white mr-3">
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
                                <span class="stamp stamp-md bg-red text-white mr-3">
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
                                <span class="stamp stamp-md bg-orange text-white mr-3">
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
