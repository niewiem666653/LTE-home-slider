<form action="" method="get" id="lte-hs-form-1">
	sortuj według
	<select name="orderby">
		<option value="id">ID</option>
		<option value="position">Pozycji</option>
		<option value="published">Widoczność</option>
	</select>
	
	<select name="orderdir">
		<option value="asc">Rosnąco</option>
		<option value="desc">Malejąco</option>
	</select>
	
	<input type="submit" class="button-secondary" value="Sortuj" />
	
</form>

<form action="" method="get" id="lte-hs-form-2">
	<div class="tablenav">
	
		<div class="alineleft action">
			<select name="bulkaction">
				<option value="0">Masowe dzialania</option>
				<option value="delete">Usuń</option>
				<option value="public">Publiczny</option>
				<option value="private">prywatny</option>
			</select>
		
			<input type="submit" class="button-secoundary" value="Zastosuj" />
		</div>
		
		<div class="tablenav-pages">
			<span class="displaying-num">4 slajdy</span>
			
			<span class="pagination-links">
				<a href="" title="idź do pierszej strony" class="first-page dispabled">←←</a>&nbsp;&nbsp;
				<a href="" title="idź do poprzedniej strony" class="prev-page dispabled">←</a>&nbsp;&nbsp;
				<span class="paging-input">1 z <span class="total-pages">4</span></span>
				
				<a href="" title="idź do następnej strony" class="next-page dispabled">→</a>&nbsp;&nbsp;
				<a href="" title="idź do ostatniej strony" class="last-page dispabled">→→</a>&nbsp;&nbsp;
				
			</span>
		</div>
		<div class="clear"></div>
	</div>
	
	<table class="widefat">
		<thead>
			<tr>
				<th class="check-column"><input type="checkbox" /></th>
				<th>ID</th>
				<th>Miniaturka</th>
				<th>Tytuł</th>
				<th>Opis</th>
				<th>Czytaj więcej</th>
				<th>Pozycja</th>
				<th>Widoczny</th>
			</tr>
		</thead>
		
		<tbody id="the-list">
		<tr>
			<td colspan="8">brak slajdów w bazie danych</td>
		</tr>
		
		<tr class="alternate">
			<th class="check-column">
				<input type="checkbox" value="1" name="bulkcheck[]" />
			</th>
			<td>
				podgląd slajdu
				<div class="row-actions">
					<span class="edit">
						<a href="" class="edit">Edytuj</a>
					</span> |
					
					<span class="trash">
						<a href="" class="delete">usuń</a>
					</span> |
				</div>
			</td>
			
			<td>slajd 1</td>
			<td>opis</td>
			<td>www.eduweb.pl</td>
			<td>1</td>
			<td>tak</td>
		</tr>
		<tr>
			<th class="check-column">
				<input type="checkbox" value="1" name="bulkcheck[]" />
			</th>
			<td>
				podgląd slajdu
				<div class="row-actions">
					<span class="edit">
						<a href="" class="edit">Edytuj</a>
					</span> |
					
					<span class="trash">
						<a href="" class="delete">Usuń</a>
					</span> |
				</div>
			</td>
			
			<td>slajd 1</td>
			<td>opis</td>
			<td>www.eduweb.pl</td>
			<td>1</td>
			<td>tak</td>
		</tr>
		
		</tbody>
	</table>
	
	<div class="tablenav">
		<div class="tablenav-pages">
			<span class="pagination-links">
				Przejdź do strony
				&nbsp;<strong>1</strong>
				&nbsp;<a href="">2</a>
				&nbsp;<a href="">3</a>
			</span>
		</div>
		
		<div class="clear"></div>
	</div>
	
	
</form>