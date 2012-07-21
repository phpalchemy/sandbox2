{extends file="master.tpl"}

{block name=title} personalized{/block}

{block name=body}
    <h1>This is a personalized template</h1>
    <table border="1">
        <tr><td width="30%"><h2>Sample</h2></td>
        <td>{form_widget id=contact_form}</td></tr>
    </table>
{/block}