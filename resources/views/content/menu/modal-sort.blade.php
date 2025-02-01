 <form action="" id="form-sort" method="post">
     <div class="modal fade" id="modal_sort" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog modal-dialog-scrollable" role="document">
             <div class="modal-content">
                 @csrf
                 <div class="modal-header">
                     <h5 class="modal-title" id="modalScrollableTitle">Sort Menu</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <div id="custome_loading" class="custome-loading custom_loading_all d-none">
                         <div class="spinner-border spinner-border-lg text-primary" role="status">
                             <span class="sr-only">Loading...</span>
                         </div>
                     </div>
                     <div class="dd">
                         <ol class="dd-list">
                             {{-- @foreach ($menusParent as $parentMenu)
                                 @php
                                     $is_header = '';
                                     if ($parentMenu->is_header) {
                                         $is_header = 'is-header';
                                     }
                                 @endphp
                                 <li class="dd-item" data-id="{{ $parentMenu->id }}">
                                     <div class="dd-handle {{ $is_header }}">{{ $parentMenu->name }}</div>
                                 </li>
                             @endforeach --}}
                         </ol>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Simpan & Reload</button>
                 </div>
             </div>
         </div>
     </div>
 </form>
