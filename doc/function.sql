-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS now_utc();
CREATE FUNCTION now_utc() RETURNS timestamp without time zone
    LANGUAGE sql
    AS $$SELECT timezone('UTC', timeofday()::timestamptz);$$;
--    AS $$SELECT NOW() at time zone 'UTC';$$;

ALTER function now_utc() owner to pongo_overlord;
-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS utc_to_unixmicrotime(timestamp without time zone);
CREATE FUNCTION utc_to_unixmicrotime(timestamp without time zone) RETURNS bigint
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT (EXTRACT(EPOCH FROM $1) * 1000000)::bigint;$_$;

ALTER FUNCTION public.utc_to_unixmicrotime(timestamp without time zone) OWNER TO pongo_overlord;
-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS unixmicrotime_to_utc(bigint);
CREATE FUNCTION unixmicrotime_to_utc(bigint) RETURNS timestamp without time zone
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT (timestamp 'epoch' + (interval '1 s' * ($1/1000000)) + (interval '1 microseconds' * ($1 - (($1/1000000)*1000000))))::TIMESTAMP AS result$_$;

ALTER FUNCTION public.unixmicrotime_to_utc(bigint) OWNER TO pongo_overlord;
-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS bytea_list2json(bytea_list bytea[]);
CREATE OR REPLACE FUNCTION bytea_list2json(bytea_list bytea[])
RETURNS text
LANGUAGE plpgsql AS $$
DECLARE
    item bytea;
    i bigint;
    size bigint;
    tmp text[];
BEGIN
    i := 1;
    size := array_length(bytea_list, 1) + 1;

    WHILE i < size
    LOOP
        item = bytea_list[i];
        tmp = array_append(tmp, encode(item, 'hex'));
        i = i + 1;
    END LOOP;

    RETURN to_json(tmp);
END
$$;
-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
DROP FUNCTION IF EXISTS uuid_list2json(uuid_list uuid[]);
CREATE OR REPLACE FUNCTION uuid_list2json(uuid_list uuid[])
RETURNS json
LANGUAGE plpgsql AS $$
DECLARE
    item uuid;
    i bigint;
    size bigint;
    tmp text[];
BEGIN
    i := 1;
    size := array_length(uuid_list, 1) + 1;

    WHILE i < size
    LOOP
        item = uuid_list[i];
        tmp = array_append(tmp, replace(item::text, '-', ''));
        i = i + 1;
    END LOOP;

    RETURN to_json(tmp);
END
$$;
-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --
